<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
  
class master_rekananshippings extends CI_Model 
{

    public function __construct() 
    {
        parent::__construct();
    }


    /**
     *  Get All data master_rekananshipping
     *
     *  @param limit  : Integer
     *  @param offset : Integer
     *
     *  @return array
     *
     */
    public function get_all($limit, $offset) 
    {
		$this->db->select('rekanan_id','rekananshipping_line','rekananshipping_address','rekananshipping_contactemail','rekananshipping_contacthp','rekananshipping_contactname','rekananshipping_contacttelp','rekananshipping_desc','rekananshipping_isactive','rekananshipping_type','rekananshipping_name','rekananshipping_namereport','rekananshipping_npwp','rekananshipping_npwp_addr','rekananshipping_npwp_name,master_branch.branch_name as branch_name, rekananshippingtype_name as type_name ');
		$this->db->join('master_branch','master_branch.branch_id = master_rekananshipping.branch_id ');
		$this->db->join('master_rekananshippingtype','master_rekananshippingtype.rekananshipping_type = master_rekananshipping.rekananshipping_type ');
        $result = $this->db->get('master_rekananshipping');

        if ($result->num_rows() > 0) 
        {
            return $result->result_array();
        } 
        else 
        {
            return array();
        }
    }

    

    /**
     *  Count All master_rekananshipping
     *    
     *  @return Integer
     *
     */
    public function count_all()
    {
        $this->db->from('master_rekananshipping');
        return $this->db->count_all_results();
    }
    

    /**
    * Search All master_rekananshipping
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
        
        $this->db->limit($limit, $offset);
        $result = $this->db->get('master_rekananshipping');

        if ($result->num_rows() > 0) 
        {
            return $result->result_array();
        } 
        else 
        {
            return array();
        }
    }

    
    
    
    
    
    /**
    * Search All master_rekananshipping
    * @param keyword : mixed
    *
    * @return Integer
    *
    */
    public function count_all_search()
    {
        $keyword = $this->session->userdata('keyword');
        $this->db->from('master_rekananshipping');        
        
        return $this->db->count_all_results();
    }


    
    
    
    /**
    *  Get One master_rekananshipping
    *
    *  @param id : Integer
    *
    *  @return array
    *
    */
    public function get_one($rekanan_id) 
    {
         
		$query = $this->db->query('SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY rekanan_id asc) AS row,(Count(*) OVER()) AS rows, a.*,b.branch_name,c.rekananshippingtype_name as type_name FROM master_rekananshipping a 
		left join master_branch b on a.branch_id=b.branch_id
		left join master_rekananshippingtype c on c.rekananshippingtype_id = a.rekananshipping_type  
		where a.rekanan_id ='.$rekanan_id.'  ) AS VW 
		order by row asc');  
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
    /**
    *  Get One master_rekananshipping
    *
    *  @param id : Integer
    *
    *  @return array
    *
    */
    public function get_one_edit($rekanan_id,$rekananshipping_line) 
    {
         
		$query = $this->db->query('SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY rekanan_id asc) AS row,(Count(*) OVER()) AS rows,* FROM master_rekananshipping where rekanan_id ='.$rekanan_id.' and rekananshipping_line = '.$rekananshipping_line.' ) AS VW 
		order by row asc');  
        $result =$query->row_array();
		 
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
    *  Default form data master_rekananshipping
    *  @return array
    *
    */
    public function add()
    {
        $data = array(
            
                'rekanan_id' => '',
            
                'rekananshipping_line' => '',
            
                'rekananshipping_name' => '',
            
                'rekananshipping_address' => '',
            
                'rekananshipping_contactname' => '',
            
                'rekananshipping_contacthp' => '',
            
                'rekananshipping_contacttelp' => '',
            
                'rekananshipping_contactemail' => '',
            
                'rekananshipping_profitsharringvalue' => '',
            
                'rekananshipping_reglistrik' => '',
            
                'rekananshipping_regair' => '',
            
                'rekananshipping_reggas' => '',
            
                'noreg_air' => '',
            
                'noreg_gas' => '',
            
                'noreg_listrik' => '',
            
                'salesarea_id' => '',
            
                'rowid' => '',
            
                'noreg_solar' => '',
            
                'rekananshipping_regsolar' => '',
            
                'rekananshipping_tax' => 10,
            
                'branch_id' => '',
            
                'rekananshipping_isactive' => '',
            
                'rekananshipping_type' => '',
            
                'rekananshipping_desc' => '',
            
                'rekananshipping_namereport' => '',
            
                'rekananshipping_npwp' => '',
            
                'rekananshipping_npwp_addr' => '',
            
                'rekananshipping_npwp_name' => '',
				
                'rekananshipping_type' => '',
				
                'rowid' => '',
				
                'rekananshipping_tax' => '10',
            
        );

        return $data;
    }

    
	public function getDebtorCode($branch_id,$rekanan_id)
	{
		$branch_output = '';
		$sql = "exec cp_getDebtorCode'$branch_id','$rekanan_id',$branch_output OUTPUT"; 
		$result = $this->db->query($sql)->row_array();
		return  $result['debtor'];
	}
    
    
    
    /**
    *  Save data Post
    *
    *  @return void
    *
    */
    public function save($id_rekanan) 
    {
		
		$branch_id = strip_tags($this->input->post('branch_id', TRUE));
		
		if($id_rekanan != '' and $branch_id != '')
		{ 
			  $branch_id = strip_tags($this->input->post('branch_id', TRUE));
			  $ship_name = html_entity_decode($this->input->post('rekananshipping_name'));
			  $ship_nameReport = html_entity_decode($this->input->post('rekananshipping_namereport'));

			  $re = "/''|(')/";  
			  $subst = "''"; 
			  $ship_name = preg_replace($re, $subst, $ship_name);
			  $ship_ship_nameReportame = preg_replace($re, $subst, $ship_nameReport);

			  $tax = $this->input->post('rekananshipping_tax');
			  $taxV = $tax == '' ? 10 : $tax;
			   
				$rekananshipping_line = ($this->get_line($id_rekanan) + 10);
				
				/* update Utilities Air dulu **/
				
				$rekananutilitiesair_line            	= $this->input->post('rekananutilitiesair_line');
				$rekananutilitiesair_reg            	= $this->input->post('rekananutilitiesair_reg');
				$rekananutilitiesair_unit            	= $this->input->post('rekananutilitiesair_unit');
				$rekananutilitiesair_diameterpipa      	= $this->input->post('rekananutilitiesair_diameterpipa');
				$rekananutilitiesair_abonemen          	= $this->input->post('rekananutilitiesair_abonemen');
				$rekananutilitiesair_admpercent        	= $this->input->post('rekananutilitiesair_admpercent');
				$rekananutilitiesair_adm            	= $this->input->post('rekananutilitiesair_adm');
				$rekananutilitiesair_phairkotor        	= $this->input->post('rekananutilitiesair_phairkotor');
				$rekananutilitiesair_phmeter           	= $this->input->post('rekananutilitiesair_phmeter');
				$phairkotor_isdisabled          		= $this->input->post('phairkotor_isdisabled');		
				$addkode      							= $this->input->post('addkode');								
				$rekananutilitiesair_iscountself   		= $this->input->post('rekananutilitiesair_iscountself');
				$rekananutilitiesair_isadditional   	= $this->input->post('rekananutilitiesair_isadditional');
				$event   	= $this->input->post('event');
				//echo var_dump($_POST);exit; 
				//echo 'bug - '.$rekananutilitiesair_isadditional[1];exit;
				
				// $this->db->where('rekanan_id', $id_rekanan);
				// $this->db->where('rekananshipping_line', $rekananshipping_line);
				// $this->db->delete('master_rekananutilitiesair');
            
				if($rekananutilitiesair_reg != '')
				{
					foreach ( $rekananutilitiesair_reg as $key => $value)
					{   
						$d_event       		= $event[$key];
						
						$d_rekananutilitiesair_line       		= $rekananutilitiesair_line[$key]; 
						
						$re = "/''|(')/"; 
						$str = $rekananutilitiesair_reg[$key]; 
						$subst = "''"; 
						$d_rekananutilitiesair_reg = preg_replace($re, $subst, $str);

						
						$d_rekananutilitiesair_unit       		= $rekananutilitiesair_unit[$key];
						$d_rekananutilitiesair_diameterpipa 	= $rekananutilitiesair_diameterpipa[$key];
						$d_rekananutilitiesair_abonemen 		=  $rekananutilitiesair_abonemen[$key];
						$d_rekananutilitiesair_admpercent 		=  $rekananutilitiesair_admpercent[$key];
						$d_rekananutilitiesair_adm 				=  $rekananutilitiesair_adm[$key];
						$d_rekananutilitiesair_phairkotor 		=  $rekananutilitiesair_phairkotor[$key];
						$d_rekananutilitiesair_phmeter 			=  $rekananutilitiesair_phmeter[$key];
						$d_phairkotor_isdisabled 				=  (int)$phairkotor_isdisabled[$key];
						$d_addkode 								=  $addkode[$key];												
						$d_rekananutilitiesair_iscountself 		=  (int)$rekananutilitiesair_iscountself[$key];
						
						
						$d_rekananutilitiesair_isadditional 		=  (int)$rekananutilitiesair_isadditional[$key];

						if($d_event == 'ADD')
						{
							 $this->db->query("exec ms_MstRekananutilitiesair_Insert '$id_rekanan',$rekananshipping_line,'$d_rekananutilitiesair_line','$d_rekananutilitiesair_reg','$region_id','$branch_id','$d_rekananutilitiesair_unit','$d_rekananutilitiesair_diameterpipa',$d_rekananutilitiesair_adm,$d_rekananutilitiesair_admpercent,' $d_rekananutilitiesair_phairkotor',$d_rekananutilitiesair_phmeter,$d_rekananutilitiesair_isadditional,0,$d_rekananutilitiesair_abonemen,$d_phairkotor_isdisabled,'$d_addkode','',$d_rekananutilitiesair_iscountself ");
						}
						if($d_event == 'EDIT')
						{
                        
							 $this->db->query("exec ms_MstRekananutilitiesair_Update '$id_rekanan',$rekananshipping_line,'$d_rekananutilitiesair_line','$d_rekananutilitiesair_reg','$region_id','$branch_id','$d_rekananutilitiesair_unit','$d_rekananutilitiesair_diameterpipa',$d_rekananutilitiesair_adm,$d_rekananutilitiesair_admpercent,' $d_rekananutilitiesair_phairkotor',$d_rekananutilitiesair_phmeter,$d_rekananutilitiesair_isadditional,0,$d_rekananutilitiesair_abonemen,$d_phairkotor_isdisabled,'$d_addkode','',$d_rekananutilitiesair_iscountself ");
						}
						  //echo $d_rekananutilitiesair_isadditional;
						 
					} 
				}
				
				/** end  Air **/
				
				/* update Utilities gas dulu **/
						
				$rekananutilitiesgas_line            	= $this->input->post('rekananutilitiesgas_line');
				$rekananutilitiesgas_reg            	= html_entity_decode($this->input->post('rekananutilitiesgas_reg'));
				$rekananutilitiesgas_unit            	= $this->input->post('rekananutilitiesgas_unit');
				$rekananutilitiesgas_diameterpipa      	= $this->input->post('rekananutilitiesgas_diameterpipa');
				$rekananutilitiesgas_mfaktor          	= $this->input->post('rekananutilitiesgas_mfaktor');
				$rekananutilitiesgas_pressure          	= $this->input->post('rekananutilitiesgas_pressure');
				$rekananutilitiesgas_tarif          	= $this->input->post('rekananutilitiesgas_tarif');
				$rekananutilitiesgas_admpercent        	= $this->input->post('rekananutilitiesgas_admpercent');
				$rekananutilitiesgas_adm            	= $this->input->post('rekananutilitiesgas_adm');
				$rekananutilitiesgas_phmeter           	= $this->input->post('rekananutilitiesgas_phmeter');				
				$addkode      							= $this->input->post('addkode');								
				$rekananutilitiesgas_iscountself   		= $this->input->post('rekananutilitiesgas_iscountself');
				$rekananutilitiesgas_isadditional   		= $this->input->post('rekananutilitiesgas_isadditional');
				$event   	= $this->input->post('event');
				//echo var_dump($_POST);exit; 
				//echo 'bug - '.$rekananutilitiesgas_isadditional[1];exit;
				
				// $this->db->where('rekanan_id', $id_rekanan);
				// $this->db->where('rekananshipping_line', $rekananshipping_line);
				// $this->db->delete('master_rekananutilitiesgas');
				
				if($rekananutilitiesgas_reg != '')
				{
					foreach ( $rekananutilitiesgas_reg as $key => $value)
					{   
						$d_event = $event[$key];
						$d_rekananutilitiesgas_line       		= $rekananutilitiesgas_line[$key];
						 
						
						$re = "/''|(')/"; 
						$str = $rekananutilitiesgas_reg[$key]; 
						$subst = "''"; 
						$d_rekananutilitiesgas_reg = preg_replace($re, $subst, $str);

						$d_rekananutilitiesgas_unit       		= $rekananutilitiesgas_unit[$key];
						$d_rekananutilitiesgas_diameterpipa 	= $rekananutilitiesgas_diameterpipa[$key];
						$d_rekananutilitiesgas_mfaktor 			=  $rekananutilitiesgas_mfaktor[$key];
						$d_rekananutilitiesgas_pressure 		=  $rekananutilitiesgas_pressure[$key];
						$d_rekananutilitiesgas_tarif 			=  $rekananutilitiesgas_tarif[$key];
						$d_rekananutilitiesgas_admpercent 		=  $rekananutilitiesgas_admpercent[$key];
						$d_rekananutilitiesgas_adm 				=  $rekananutilitiesgas_adm[$key];				
						$d_rekananutilitiesgas_phmeter 			=  $rekananutilitiesgas_phmeter[$key];				
						$d_addkode 								=  $addkode[$key];												
						$d_rekananutilitiesgas_iscountself 		=  (int)$rekananutilitiesgas_iscountself[$key]; 
						$d_rekananutilitiesgas_isadditional 		=  (int)$rekananutilitiesgas_isadditional[$key];
				 
						if($d_event == 'ADD')
						{
							 //echo $d_rekananutilitiesgas_isadditional;
						  $this->db->query("exec ms_MstRekananutilitiesgas_Insert '$id_rekanan',$rekananshipping_line,'$d_rekananutilitiesgas_line','$d_rekananutilitiesgas_reg','$region_id','$branch_id','$d_rekananutilitiesgas_unit','$d_rekananutilitiesgas_diameterpipa',$d_rekananutilitiesgas_adm,$d_rekananutilitiesgas_admpercent,0,$d_rekananutilitiesgas_phmeter,$rekananutilitiesgas_isadditional,0,$d_rekananutilitiesgas_mfaktor,$d_rekananutilitiesgas_pressure,$d_rekananutilitiesgas_tarif,'$d_addkode','',$d_rekananutilitiesgas_iscountself ");
						}
						if($d_event == 'EDIT')
						{
							
							 //echo $d_rekananutilitiesgas_isadditional;
						  $this->db->query("exec ms_MstRekananutilitiesgas_Update '$id_rekanan',$rekananshipping_line,'$d_rekananutilitiesgas_line','$d_rekananutilitiesgas_reg','$region_id','$branch_id','$d_rekananutilitiesgas_unit','$d_rekananutilitiesgas_diameterpipa',$d_rekananutilitiesgas_adm,$d_rekananutilitiesgas_admpercent,0,$d_rekananutilitiesgas_phmeter,$rekananutilitiesgas_isadditional,0,$d_rekananutilitiesgas_mfaktor,$d_rekananutilitiesgas_pressure,$d_rekananutilitiesgas_tarif,'$d_addkode','',$d_rekananutilitiesgas_iscountself ");
						}
						 
					} 
				}
				
				/** end  gas **/
				
				/* update Utilities listrik dulu **/
						
				$rekananutilitieslistrik_line            	= $this->input->post('rekananutilitieslistrik_line');
				$rekananutilitieslistrik_reg            	= html_entity_decode($this->input->post('rekananutilitieslistrik_reg'));
				$rekananutilitieslistrik_reglimit           = $this->input->post('rekananutilitieslistrik_reglimit');
				$rekananutilitieslistrik_unit            	= $this->input->post('rekananutilitieslistrik_unit');
				$rekananutilitieslistrik_amp      			= $this->input->post('rekananutilitieslistrik_amp');
				$rekananutilitieslistrik_phase          	= $this->input->post('rekananutilitieslistrik_phase');
				$rekananutilitieslistrik_kva          		= $this->input->post('rekananutilitieslistrik_kva');
				$rekananutilitieslistrik_faktor          	= $this->input->post('rekananutilitieslistrik_faktor');
				$rekananutilitieslistrik_issingglemeter     = $this->input->post('rekananutilitieslistrik_issingglemeter');
				$rekananutilitieslistrik_isblocked          = $this->input->post('rekananutilitieslistrik_isblocked');
				$rekananutilitieslistrik_isgenset           = $this->input->post('rekananutilitieslistrik_isgenset');						
				$utilitieskva_id           					= $this->input->post('utilitieskva_id');				
				$tariflwbp_calcbyuser           			= $this->input->post('tariflwbp_calcbyuser');				
				$tarifwbp_calcbyuser           				= $this->input->post('tarifwbp_calcbyuser');				
				$selisih_calcbyuser           				= $this->input->post('selisih_calcbyuser');				
				$selisihlwbp_calcbyuser           			= $this->input->post('selisihlwbp_calcbyuser');				
				$selisihwbp_calcbyuser           			= $this->input->post('selisihwbp_calcbyuser');				
				$pemakaianwbp_calcbyuser           			= $this->input->post('pemakaianwbp_calcbyuser');				
				$pemakaianlwbp_calcbyuser           		= $this->input->post('pemakaianlwbp_calcbyuser');				
				$rekananutilitieslistrik_admpercent         = $this->input->post('rekananutilitieslistrik_admpercent');				
				$rekananutilitieslistrik_admamount          = $this->input->post('rekananutilitieslistrik_admamount');				
				$rekananutilitieslistrik_bpju           	= $this->input->post('rekananutilitieslistrik_bpju');				
				$tarif_pln           						= $this->input->post('tarif_pln');				
				$tarif_genset           					= $this->input->post('tarif_genset');				
				$bea_beban           						= $this->input->post('bea_beban');	
				$bea_energi           						= $this->input->post('bea_energi');	
				$rekananutilitieslistrik_type           	= $this->input->post('rekananutilitieslistrik_type');							
				$addkode      								= $this->input->post('addkode');								
				$rekananutilitieslistrik_iscountself   		= $this->input->post('rekananutilitieslistrik_iscountself');
				$rekananutilitieslistrik_isadditional   		= $this->input->post('rekananutilitieslistrik_isadditional');
				$event   	= $this->input->post('event');
				//echo var_dump($_POST);exit; 
				//echo 'bug - '.$rekananutilitieslistrik_isadditional[1];exit;
				
				// $this->db->where('rekanan_id', $id_rekanan);
				// $this->db->where('rekananshipping_line', $rekananshipping_line);
				// $this->db->delete('master_rekananutilitieslistrik');

				if($rekananutilitieslistrik_reg != '')
				{
					foreach ( $rekananutilitieslistrik_reg as $key => $value)
					{   
						$d_event = $event[$key];
						$d_rekananutilitieslistrik_line       		= $rekananutilitieslistrik_line[$key];
						 
					
						$re = "/''|(')/"; 
						$str = $rekananutilitieslistrik_reg[$key]; 
						$subst = "''"; 
						$d_rekananutilitieslistrik_reg = preg_replace($re, $subst, $str);

						$d_rekananutilitieslistrik_unit       		= $rekananutilitieslistrik_unit[$key];
						$d_rekananutilitieslistrik_reglimit         = $rekananutilitieslistrik_reglimit[$key];
						$d_rekananutilitieslistrik_amp      		= $rekananutilitieslistrik_amp[$key];
						$d_rekananutilitieslistrik_phase          	= $rekananutilitieslistrik_phase[$key];
						$d_rekananutilitieslistrik_kva          	= $rekananutilitieslistrik_kva[$key];
						$d_rekananutilitieslistrik_faktor          	= $rekananutilitieslistrik_faktor[$key];
						$d_rekananutilitieslistrik_issingglemeter   = (int)$rekananutilitieslistrik_issingglemeter[$key];
						$d_rekananutilitieslistrik_isblocked        = (int)$rekananutilitieslistrik_isblocked[$key];
						$d_rekananutilitieslistrik_isgenset         = (int)$rekananutilitieslistrik_isgenset[$key];						
						$d_utilitieskva_id           				= $utilitieskva_id[$key];				
						$d_tariflwbp_calcbyuser           			= (int)$tariflwbp_calcbyuser[$key];				
						$d_tarifwbp_calcbyuser           			= (int)$tarifwbp_calcbyuser[$key];				
						$d_selisih_calcbyuser           			= (int)$selisih_calcbyuser[$key];			
						$d_selisihlwbp_calcbyuser           		= (int)$selisihlwbp_calcbyuser[$key];			
						$d_selisihwbp_calcbyuser           			= (int)$selisihwbp_calcbyuser[$key];			
						$d_pemakaianwbp_calcbyuser           		= (int)$pemakaianwbp_calcbyuser[$key];				
						$d_pemakaianlwbp_calcbyuser           		= (int)$pemakaianlwbp_calcbyuser[$key];				
						$d_rekananutilitieslistrik_admpercent       = $rekananutilitieslistrik_admpercent[$key];			
						$d_rekananutilitieslistrik_admamount        = $rekananutilitieslistrik_admamount[$key];			
						$d_rekananutilitieslistrik_bpju           	= $rekananutilitieslistrik_bpju[$key];			
						$d_tarif_pln           						= $tarif_pln[$key];				
						$d_tarif_genset           					= $tarif_genset[$key];				
						$d_bea_beban           						= $bea_beban[$key];	
						$d_bea_energi           					= $bea_energi[$key];	
						$d_rekananutilitieslistrik_type           	= $rekananutilitieslistrik_type[$key];								
						$d_addkode 									= $addkode[$key];												
						$d_rekananutilitieslistrik_iscountself 		= (int)$rekananutilitieslistrik_iscountself[$key];
						$d_rekananutilitieslistrik_isadditional 		= (int)$rekananutilitieslistrik_isadditional[$key];
						
			 
						if($d_event == 'ADD')
						{
							  //echo $d_rekananutilitieslistrik_isadditional;
						  $this->db->query("exec ms_MstRekananutilitieslistrik_Insert '$id_rekanan',$d_rekananutilitieslistrik_reglimit,$rekananshipping_line,$d_rekananutilitieslistrik_line,'$d_rekananutilitieslistrik_reg','','$branch_id','$d_rekananutilitieslistrik_unit',$d_rekananutilitieslistrik_amp,$d_rekananutilitieslistrik_phase,$d_rekananutilitieslistrik_kva,$d_rekananutilitieslistrik_faktor,$d_rekananutilitieslistrik_isadditional,$d_rekananutilitieslistrik_issingglemeter,$d_rekananutilitieslistrik_isblocked,$d_rekananutilitieslistrik_isgenset,$d_tariflwbp_calcbyuser,$d_tarifwbp_calcbyuser,$d_selisih_calcbyuser,$d_selisihlwbp_calcbyuser,$d_selisihwbp_calcbyuser,$d_pemakaianwbp_calcbyuser,$d_pemakaianlwbp_calcbyuser,'$d_utilitieskva_id', 
											$d_rekananutilitieslistrik_admpercent,$d_rekananutilitieslistrik_admamount,$d_rekananutilitieslistrik_bpju,$d_tarif_pln,$d_tarif_genset,$d_bea_beban,$d_bea_energi,$d_rekananutilitieslistrik_type,'$d_addkode','',$d_rekananutilitieslistrik_iscountself	");
						} 
						if($d_event == 'EDIT')
						{

						  $this->db->query("exec ms_MstRekananutilitieslistrik_Update '$id_rekanan',$d_rekananutilitieslistrik_reglimit,$rekananshipping_line,$d_rekananutilitieslistrik_line,'$d_rekananutilitieslistrik_reg','','$branch_id','$d_rekananutilitieslistrik_unit',$d_rekananutilitieslistrik_amp,$d_rekananutilitieslistrik_phase,$d_rekananutilitieslistrik_kva,$d_rekananutilitieslistrik_faktor,$d_rekananutilitieslistrik_isadditional,$d_rekananutilitieslistrik_issingglemeter,$d_rekananutilitieslistrik_isblocked,$d_rekananutilitieslistrik_isgenset,$d_tariflwbp_calcbyuser,$d_tarifwbp_calcbyuser,$d_selisih_calcbyuser,$d_selisihlwbp_calcbyuser,$d_selisihwbp_calcbyuser,$d_pemakaianwbp_calcbyuser,$d_pemakaianlwbp_calcbyuser,'$d_utilitieskva_id', 
											$d_rekananutilitieslistrik_admpercent,$d_rekananutilitieslistrik_admamount,$d_rekananutilitieslistrik_bpju,$d_tarif_pln,$d_tarif_genset,$d_bea_beban,$d_bea_energi,$d_rekananutilitieslistrik_type,'$d_addkode','',$d_rekananutilitieslistrik_iscountself	");
						}
						
						
					} 
				}
				
				/** end  listrik **/	
		}
      
    }
    
    
    

    
    /**
    *  Update modify data
    *
    *  @param id : Integer
    *
    *  @return void
    *
    */
    public function update($id_rekanan,$rekananshipping_line)
    {
		 
		$region_id = '';
		$branch_id = $this->input->post('branch_id');
		/* update Utilities Air dulu **/
				
		$rekananutilitiesair_line            	= $this->input->post('rekananutilitiesair_line');
		$rekananutilitiesair_reg            	= $this->input->post('rekananutilitiesair_reg');
		$rekananutilitiesair_unit            	= $this->input->post('rekananutilitiesair_unit');
		$rekananutilitiesair_diameterpipa      	= $this->input->post('rekananutilitiesair_diameterpipa');
		$rekananutilitiesair_abonemen          	= $this->input->post('rekananutilitiesair_abonemen');
		$rekananutilitiesair_admpercent        	= $this->input->post('rekananutilitiesair_admpercent');
		$rekananutilitiesair_adm            	= $this->input->post('rekananutilitiesair_adm');
		$rekananutilitiesair_phairkotor        	= $this->input->post('rekananutilitiesair_phairkotor');
		$rekananutilitiesair_phmeter           	= $this->input->post('rekananutilitiesair_phmeter');
		$phairkotor_isdisabled          		= $this->input->post('phairkotor_isdisabled');		
		$addkode      							= $this->input->post('addkode');								
		$rekananutilitiesair_iscountself   		= $this->input->post('rekananutilitiesair_iscountself'); 
		$rekananutilitiesair_isadditional   	= $this->input->post('rekananutilitiesair_isadditional');
		$event   	= $this->input->post('event_air');
		//echo var_dump($_POST);exit; 
		//echo 'bug - '.$rekananutilitiesair_isadditional[1];exit;
		
		// $this->db->where('rekanan_id', $id_rekanan);
		// $this->db->where('rekananshipping_line', $rekananshipping_line);
        // $this->db->delete('master_rekananutilitiesair');
		
		// echo "DEBUG :<br/>";
		// echo "<pre/>";
		// echo var_dump($_POST);
		// exit; 
		if($rekananutilitiesair_reg != '')
		{
			foreach ( $rekananutilitiesair_reg as $key => $value)
			{   
				$d_event =  $event[$key];
				$d_rekananutilitiesair_line       		= $rekananutilitiesair_line[$key];
				$d_rekananutilitiesair_reg       		= str_replace("'","''",$rekananutilitiesair_reg[$key]);
				$d_rekananutilitiesair_unit       		= $rekananutilitiesair_unit[$key];
				$d_rekananutilitiesair_diameterpipa 	= $rekananutilitiesair_diameterpipa[$key];
				$d_rekananutilitiesair_abonemen 		=  $rekananutilitiesair_abonemen[$key];
				$d_rekananutilitiesair_admpercent 		=  $rekananutilitiesair_admpercent[$key];
				$d_rekananutilitiesair_adm 				=  $rekananutilitiesair_adm[$key];
				$d_rekananutilitiesair_phairkotor 		=  $rekananutilitiesair_phairkotor[$key];
				$d_rekananutilitiesair_phmeter 			=  $rekananutilitiesair_phmeter[$key];
				$d_phairkotor_isdisabled 				=  (int)$phairkotor_isdisabled[$key];
				$d_addkode 								=  $addkode[$key];												
				$d_rekananutilitiesair_iscountself 		=  (int)$rekananutilitiesair_iscountself[$key];
				$d_rekananutilitiesair_isadditional		=  (int)$rekananutilitiesair_isadditional[$key];
				

				if($d_event == 'ADD')
				{
					  //echo $d_rekananutilitiesair_isadditional;
				 $this->db->query("exec ms_MstRekananutilitiesair_Insert '$id_rekanan',$rekananshipping_line,'$d_rekananutilitiesair_line','$d_rekananutilitiesair_reg','$region_id','$branch_id','$d_rekananutilitiesair_unit','$d_rekananutilitiesair_diameterpipa',$d_rekananutilitiesair_adm,$d_rekananutilitiesair_admpercent,' $d_rekananutilitiesair_phairkotor',$d_rekananutilitiesair_phmeter,$d_rekananutilitiesair_isadditional,0,$d_rekananutilitiesair_abonemen,$d_phairkotor_isdisabled,'$d_addkode','',$d_rekananutilitiesair_iscountself ");
				}
				if($d_event == 'EDIT')
				{
					  //echo $d_rekananutilitiesair_isadditional;
				 $this->db->query("exec ms_MstRekananutilitiesair_Update '$id_rekanan',$rekananshipping_line,'$d_rekananutilitiesair_line','$d_rekananutilitiesair_reg','$region_id','$branch_id','$d_rekananutilitiesair_unit','$d_rekananutilitiesair_diameterpipa',$d_rekananutilitiesair_adm,$d_rekananutilitiesair_admpercent,' $d_rekananutilitiesair_phairkotor',$d_rekananutilitiesair_phmeter,$d_rekananutilitiesair_isadditional,0,$d_rekananutilitiesair_abonemen,$d_phairkotor_isdisabled,'$d_addkode','',$d_rekananutilitiesair_iscountself ");
				} 
				
			} 
		}
		
		/** end  Air **/
		
		/* update Utilities gas dulu **/
				
		$rekananutilitiesgas_line            	= $this->input->post('rekananutilitiesgas_line');
		$rekananutilitiesgas_reg            	= $this->input->post('rekananutilitiesgas_reg');
		$rekananutilitiesgas_unit            	= $this->input->post('rekananutilitiesgas_unit');
		$rekananutilitiesgas_diameterpipa      	= $this->input->post('rekananutilitiesgas_diameterpipa');
		$rekananutilitiesgas_mfaktor          	= $this->input->post('rekananutilitiesgas_mfaktor');
		$rekananutilitiesgas_pressure          	= $this->input->post('rekananutilitiesgas_pressure');
		$rekananutilitiesgas_tarif          	= $this->input->post('rekananutilitiesgas_tarif');
		$rekananutilitiesgas_admpercent        	= $this->input->post('rekananutilitiesgas_admpercent');
		$rekananutilitiesgas_adm            	= $this->input->post('rekananutilitiesgas_adm');
		$rekananutilitiesgas_phmeter           	= $this->input->post('rekananutilitiesgas_phmeter');				
		$addkode      							= $this->input->post('addkode');								
		$rekananutilitiesgas_iscountself   		= $this->input->post('rekananutilitiesgas_iscountself');
		
		$rekananutilitiesgas_isadditional   	= $this->input->post('rekananutilitiesgas_isadditional');
		$event   	= $this->input->post('event_gas');
		
		//echo var_dump($rekananutilitiesgas_isadditional[2]);exit;
		
		// $this->db->where('rekanan_id', $id_rekanan);
		// $this->db->where('rekananshipping_line', $rekananshipping_line);
        // $this->db->delete('master_rekananutilitiesgas');
		
		if($rekananutilitiesgas_line != '')
		{
			foreach ( $rekananutilitiesgas_line as $key => $value)
			{   
				$d_event =  $event[$key];
				$d_rekananutilitiesgas_line       		= $rekananutilitiesgas_line[$key];
				 

				$re = "/''|(')/"; 
				$str = $rekananutilitiesgas_reg[$key]; 
				$subst = "''"; 
				$d_rekananutilitiesgas_reg = preg_replace($re, $subst, $str);

				$d_rekananutilitiesgas_unit       		= $rekananutilitiesgas_unit[$key];
				$d_rekananutilitiesgas_diameterpipa 	= $rekananutilitiesgas_diameterpipa[$key];
				$d_rekananutilitiesgas_mfaktor 			=  $rekananutilitiesgas_mfaktor[$key];
				$d_rekananutilitiesgas_pressure 		=  $rekananutilitiesgas_pressure[$key];
				$d_rekananutilitiesgas_tarif 			=  $rekananutilitiesgas_tarif[$key];
				$d_rekananutilitiesgas_admpercent 		=  $rekananutilitiesgas_admpercent[$key];
				$d_rekananutilitiesgas_adm 				=  $rekananutilitiesgas_adm[$key];				
				$d_rekananutilitiesgas_phmeter 			=  $rekananutilitiesgas_phmeter[$key];				
				$d_addkode 								=  $addkode[$key];												
				$d_rekananutilitiesgas_iscountself 		=  intval($rekananutilitiesgas_iscountself[$key]);
				$d_rekananutilitiesgas_isadditional 	=  intval($rekananutilitiesgas_isadditional[$key]);
				
			
				
				if($d_event == 'ADD')
				{ 
				// echo "<pre/>";
				// echo var_dump($_POST);
				// exit;
				$query_gas_add = "exec ms_MstRekananutilitiesgas_Insert '$id_rekanan',$rekananshipping_line,'$d_rekananutilitiesgas_line','$d_rekananutilitiesgas_reg','$region_id','$branch_id','$d_rekananutilitiesgas_unit','$d_rekananutilitiesgas_diameterpipa',$d_rekananutilitiesgas_adm,$d_rekananutilitiesgas_admpercent,0,$d_rekananutilitiesgas_phmeter,$d_rekananutilitiesgas_isadditional,0,$d_rekananutilitiesgas_mfaktor,$d_rekananutilitiesgas_pressure,$d_rekananutilitiesgas_tarif,'$d_addkode','',$d_rekananutilitiesgas_iscountself ";
				 // echo $query_gas_add;
				// exit;
				  $this->db->query($query_gas_add);
				}
				if($d_event == 'EDIT')
				{
					$query_edit_gas = "exec ms_MstRekananutilitiesgas_Update '$id_rekanan',$rekananshipping_line,'$d_rekananutilitiesgas_line','$d_rekananutilitiesgas_reg','$region_id','$branch_id','$d_rekananutilitiesgas_unit','$d_rekananutilitiesgas_diameterpipa',$d_rekananutilitiesgas_adm,$d_rekananutilitiesgas_admpercent,0,$d_rekananutilitiesgas_phmeter,$d_rekananutilitiesgas_isadditional,0,$d_rekananutilitiesgas_mfaktor,$d_rekananutilitiesgas_pressure,$d_rekananutilitiesgas_tarif,'$d_addkode','',$d_rekananutilitiesgas_iscountself ";
					//echo $d_rekananutilitiesgas_isadditional;
					
					// echo $query_edit_gas;
					// exit;
					
				    $this->db->query($query_edit_gas);
				} 
				  
			} 
		}
		
		/** end  gas **/
		
		/* update Utilities listrik dulu **/
		
		$rekananutilitieslistrik_line            	= $this->input->post('rekananutilitieslistrik_line');
		$rekananutilitieslistrik_reg            	= $this->input->post('rekananutilitieslistrik_reg');
		$rekananutilitieslistrik_reglimit           = $this->input->post('rekananutilitieslistrik_reglimit');
		$rekananutilitieslistrik_unit            	= $this->input->post('rekananutilitieslistrik_unit');
		$rekananutilitieslistrik_amp      			= $this->input->post('rekananutilitieslistrik_amp');
		$rekananutilitieslistrik_phase          	= $this->input->post('rekananutilitieslistrik_phase');
		$rekananutilitieslistrik_kva          		= $this->input->post('rekananutilitieslistrik_kva');
		$rekananutilitieslistrik_faktor          	= $this->input->post('rekananutilitieslistrik_faktor');
		$rekananutilitieslistrik_issingglemeter     = $this->input->post('rekananutilitieslistrik_issingglemeter');
		$rekananutilitieslistrik_isblocked          = $this->input->post('rekananutilitieslistrik_isblocked');
		$rekananutilitieslistrik_isgenset           = $this->input->post('rekananutilitieslistrik_isgenset');						
		$utilitieskva_id           					= $this->input->post('utilitieskva_id');				
		$tariflwbp_calcbyuser           			= $this->input->post('tariflwbp_calcbyuser');				
		$tarifwbp_calcbyuser           				= $this->input->post('tarifwbp_calcbyuser');				
		$selisih_calcbyuser           				= $this->input->post('selisih_calcbyuser');				
		$selisihlwbp_calcbyuser           			= $this->input->post('selisihlwbp_calcbyuser');				
		$selisihwbp_calcbyuser           			= $this->input->post('selisihwbp_calcbyuser');				
		$pemakaianwbp_calcbyuser           			= $this->input->post('pemakaianwbp_calcbyuser');				
		$pemakaianlwbp_calcbyuser           		= $this->input->post('pemakaianlwbp_calcbyuser');				
		$rekananutilitieslistrik_admpercent         = $this->input->post('rekananutilitieslistrik_admpercent');				
		$rekananutilitieslistrik_admamount          = $this->input->post('rekananutilitieslistrik_admamount');				
		$rekananutilitieslistrik_bpju           	= $this->input->post('rekananutilitieslistrik_bpju');				
		$tarif_pln           						= $this->input->post('tarif_pln');				
		$tarif_genset           					= $this->input->post('tarif_genset');				
		$bea_beban           						= $this->input->post('bea_beban');	
		$bea_energi           						= $this->input->post('bea_energi');	
		$rekananutilitieslistrik_type           	= $this->input->post('rekananutilitieslistrik_type');							
		$addkode      								= $this->input->post('addkode');								
		$rekananutilitieslistrik_iscountself   		= $this->input->post('rekananutilitieslistrik_iscountself');
		$rekananutilitieslistrik_isadditional   	= $this->input->post('rekananutilitieslistrik_isadditional');
		$event   	= $this->input->post('event_listrik');
		 
		  // echo "<pre>"; 
		  // echo var_dump($_POST);
		  // echo "</pre>";
		  // exit;	
		 // echo var_dump($rekananutilitieslistrik_isblocked);exit;
		// $this->db->where('rekanan_id', $id_rekanan);
		// $this->db->where('rekananshipping_line', $rekananshipping_line);
        // $this->db->delete('master_rekananutilitieslistrik');
		
		$v_q = "";
		
		if($rekananutilitieslistrik_reg != '')
		{
			 
			//echo var_dump($rekananutilitieslistrik_issingglemeter[0]);
			// echo "<br/>";
			// exit;
			//for($key=0;$key < count($rekananutilitieslistrik_line) ;$key++)
			foreach ( $rekananutilitieslistrik_reg as $key => $value)
			{   
				
				$d_event =  $event[$key]; 
				$d_rekananutilitieslistrik_line       		= $rekananutilitieslistrik_line[$key];
				 

				$re = "/''|(')/"; 
				$str = $rekananutilitieslistrik_reg[$key]; 
				$subst = "''"; 
				$d_rekananutilitieslistrik_reg = preg_replace($re, $subst, $str);

				$d_rekananutilitieslistrik_unit       		= $rekananutilitieslistrik_unit[$key];
				$d_rekananutilitieslistrik_reglimit         = $rekananutilitieslistrik_reglimit[$key];
				$d_rekananutilitieslistrik_amp      		= intval($rekananutilitieslistrik_amp[$key]);
				$d_rekananutilitieslistrik_phase          	= intval($rekananutilitieslistrik_phase[$key]);
				$d_rekananutilitieslistrik_kva          	= $rekananutilitieslistrik_kva[$key];
				$d_rekananutilitieslistrik_faktor          	= $rekananutilitieslistrik_faktor[$key];
				 
				$d_rekananutilitieslistrik_issingglemeter   = $rekananutilitieslistrik_issingglemeter[$key];
				$d_rekananutilitieslistrik_isblocked        = intval($rekananutilitieslistrik_isblocked[$key]);
				$d_rekananutilitieslistrik_isgenset         = intval($rekananutilitieslistrik_isgenset[$key]);						
				$d_utilitieskva_id           				= $utilitieskva_id[$key];				
				$d_tariflwbp_calcbyuser           			= intval($tariflwbp_calcbyuser[$key]);  			
				$d_tarifwbp_calcbyuser           			= intval($tarifwbp_calcbyuser[$key]);
				$d_selisih_calcbyuser           			= intval($selisih_calcbyuser[$key]);			
				$d_selisihlwbp_calcbyuser           		= intval($selisihlwbp_calcbyuser[$key]);  		
				$d_selisihwbp_calcbyuser           			= intval($selisihwbp_calcbyuser[$key]);  		
				$d_pemakaianwbp_calcbyuser           		= intval($pemakaianwbp_calcbyuser[$key]);  		
				$d_pemakaianlwbp_calcbyuser           		= intval($pemakaianlwbp_calcbyuser[$key]); 		
				$d_rekananutilitieslistrik_admpercent       = $rekananutilitieslistrik_admpercent[$key];			
				$d_rekananutilitieslistrik_admamount        = $rekananutilitieslistrik_admamount[$key];			
				$d_rekananutilitieslistrik_bpju           	= $rekananutilitieslistrik_bpju[$key];			
				$d_tarif_pln           						= $tarif_pln[$key];				
				$d_tarif_genset           					= $tarif_genset[$key];				
				$d_bea_beban           						= $bea_beban[$key];	
				$d_bea_energi           					= $bea_energi[$key];	
				$d_rekananutilitieslistrik_type           	= $rekananutilitieslistrik_type[$key];								
				$d_addkode 									= $addkode[$key];												
				$d_rekananutilitieslistrik_iscountself 		= intval($rekananutilitieslistrik_iscountself[$key]);
				$d_rekananutilitieslistrik_isadditional 		= intval($rekananutilitieslistrik_isadditional[$key]);
				
				//echo "<pre/>"; 
				// echo var_dump($_POST);
				// echo var_dump($d_tariflwbp_calcbyuser);
				// exit;
				/** check param **/
				$d_rekananutilitieslistrik_line       		= $rekananutilitieslistrik_line[$key]; 

				$re = "/''|(')/"; 
				$str = $rekananutilitieslistrik_reg[$key]; 
				$subst = "''"; 
				$d_rekananutilitieslistrik_reg = preg_replace($re, $subst, $str);
				
				$d_rekananutilitieslistrik_unit       		= intval($rekananutilitieslistrik_unit[$key]);
				$d_rekananutilitieslistrik_reglimit         = $rekananutilitieslistrik_reglimit[$key];
				 
				$d_rekananutilitieslistrik_amp      		= $rekananutilitieslistrik_amp[$key];
				// $d_rekananutilitieslistrik_phase          	= !empty($d_rekananutilitieslistrik_phase) ? $d_rekananutilitieslistrik_phase : 1;
				// $d_rekananutilitieslistrik_kva          	= !empty($d_rekananutilitieslistrik_kva) ? $d_rekananutilitieslistrik_kva : 1;
				// $d_rekananutilitieslistrik_faktor          	= !empty($d_rekananutilitieslistrik_faktor) ? $d_rekananutilitieslistrik_faktor :1;
				// $d_rekananutilitieslistrik_issingglemeter   = !empty($d_rekananutilitieslistrik_issingglemeter) ? $d_rekananutilitieslistrik_issingglemeter : 1;
				// $d_rekananutilitieslistrik_isblocked        = !empty($d_rekananutilitieslistrik_isblocked) ? $d_rekananutilitieslistrik_isblocked : 1;
				// $d_rekananutilitieslistrik_isgenset         = !empty($d_rekananutilitieslistrik_isgenset) ? $d_rekananutilitieslistrik_isgenset : 1;				
				// $d_utilitieskva_id           				= !empty($d_utilitieskva_id) ? $d_utilitieskva_id : 1;					
				// $d_tariflwbp_calcbyuser           			= !empty($d_tariflwbp_calcbyuser) ? $d_tariflwbp_calcbyuser : 1;				
				// $d_tarifwbp_calcbyuser           			= !empty($d_tarifwbp_calcbyuser) ? $d_tarifwbp_calcbyuser : 1;				
				// $d_selisih_calcbyuser           			= !empty($d_selisih_calcbyuser) ? $d_selisih_calcbyuser : 1;			
				// $d_selisihlwbp_calcbyuser           		= !empty($d_selisihlwbp_calcbyuser) ? $d_selisihlwbp_calcbyuser : 1;			
				// $d_selisihwbp_calcbyuser           			= !empty($d_selisihwbp_calcbyuser) ? $d_selisihwbp_calcbyuser : 1;				
				// $d_pemakaianwbp_calcbyuser           		=!empty($d_pemakaianwbp_calcbyuser) ? $d_pemakaianwbp_calcbyuser : 1;				
				// $d_pemakaianlwbp_calcbyuser           		= !empty($d_pemakaianlwbp_calcbyuser) ? $d_pemakaianlwbp_calcbyuser : 1;				
				// $d_rekananutilitieslistrik_admpercent       = !empty($d_rekananutilitieslistrik_admpercent) ? $d_rekananutilitieslistrik_admpercent :1;
				// $d_rekananutilitieslistrik_admamount        = !empty($d_rekananutilitieslistrik_admamount) ? $d_rekananutilitieslistrik_admamount :1;
				// $d_rekananutilitieslistrik_bpju           	= !empty($d_rekananutilitieslistrik_bpju) ? $d_rekananutilitieslistrik_bpju : 1;						
				$d_tarif_pln           						= !empty($d_tarif_pln) ? $d_tarif_pln :1;			
				$d_tarif_genset           					= !empty($d_tarif_genset) ? $d_tarif_genset :10;					
				$d_bea_beban           						= !empty($d_bea_beban) ? $d_bea_beban :1;	
				$d_bea_energi           					= !empty($d_bea_energi) ? $d_bea_energi :1;	
				$d_rekananutilitieslistrik_type           	= !empty($d_rekananutilitieslistrik_type) ? $d_rekananutilitieslistrik_type :1;								
				$d_addkode 									= !empty($d_addkode) ? $d_addkode :1;												
				// $d_rekananutilitieslistrik_iscountself 		= !empty($d_rekananutilitieslistrik_iscountself) ? $d_rekananutilitieslistrik_iscountself :1; 
				
				
				if($d_event == 'ADD')
				{
					//echo $d_rekananutilitieslistrik_isadditional;
						  $query = "exec ms_MstRekananutilitieslistrik_Insert '$id_rekanan',$d_rekananutilitieslistrik_reglimit,$rekananshipping_line,$d_rekananutilitieslistrik_line,'$d_rekananutilitieslistrik_reg','','$branch_id','$d_rekananutilitieslistrik_unit',$d_rekananutilitieslistrik_amp,$d_rekananutilitieslistrik_phase,$d_rekananutilitieslistrik_kva,$d_rekananutilitieslistrik_faktor,$d_rekananutilitieslistrik_isadditional,$d_rekananutilitieslistrik_issingglemeter,$d_rekananutilitieslistrik_isblocked,$d_rekananutilitieslistrik_isgenset,$d_tariflwbp_calcbyuser,$d_tarifwbp_calcbyuser,$d_selisih_calcbyuser,$d_selisihlwbp_calcbyuser,$d_selisihwbp_calcbyuser,$d_pemakaianwbp_calcbyuser,$d_pemakaianlwbp_calcbyuser,'$d_utilitieskva_id', 
											$d_rekananutilitieslistrik_admpercent,$d_rekananutilitieslistrik_admamount,$d_rekananutilitieslistrik_bpju,$d_tarif_pln,$d_tarif_genset,$d_bea_beban,$d_bea_energi,$d_rekananutilitieslistrik_type,'$d_addkode','',$d_rekananutilitieslistrik_iscountself	";
				}
				if($d_event == 'EDIT')
				{
					
					//echo $d_rekananutilitieslistrik_isadditional;
						  $query = "exec ms_MstRekananutilitieslistrik_Update '$id_rekanan',$d_rekananutilitieslistrik_reglimit,$rekananshipping_line,$d_rekananutilitieslistrik_line,'$d_rekananutilitieslistrik_reg','','$branch_id','$d_rekananutilitieslistrik_unit',$d_rekananutilitieslistrik_amp,$d_rekananutilitieslistrik_phase,$d_rekananutilitieslistrik_kva,$d_rekananutilitieslistrik_faktor,$d_rekananutilitieslistrik_isadditional,$d_rekananutilitieslistrik_issingglemeter,$d_rekananutilitieslistrik_isblocked,$d_rekananutilitieslistrik_isgenset,$d_tariflwbp_calcbyuser,$d_tarifwbp_calcbyuser,$d_selisih_calcbyuser,$d_selisihlwbp_calcbyuser,$d_selisihwbp_calcbyuser,$d_pemakaianwbp_calcbyuser,$d_pemakaianlwbp_calcbyuser,'$d_utilitieskva_id', 
											$d_rekananutilitieslistrik_admpercent,$d_rekananutilitieslistrik_admamount,$d_rekananutilitieslistrik_bpju,$d_tarif_pln,$d_tarif_genset,$d_bea_beban,$d_bea_energi,$d_rekananutilitieslistrik_type,'$d_addkode','',$d_rekananutilitieslistrik_iscountself	";
				} 
				
				  
				  // echo var_dump($rekananutilitieslistrik_isblocked[0]);
				  // echo $d_rekananutilitieslistrik_isblocked;
				  // echo "<br/>";
				  // echo $query;
				  // exit;
				  
				  $v_q .=$query;
				  
				  $this->db->query($query);
			} 
		}
		//echo $v_q;
		// echo ("<br/>".$v_q);
		// echo var_dump($rekananutilitieslistrik_isadditional);
		// exit;
		/** end  listrik **/
		
        
		// echo $this->db->last_query();exit;
    }


    
    
    
    /**
    *  Delete data by id
    *
    *  @param id : Integer
    *
    *  @return void
    *
    */
    public function destroy($id_rekanan,$rekananshipping_line)
    {       
        $this->db->where('rekanan_id', $id_rekanan);
        $this->db->where('rekananshipping_line', $rekananshipping_line);
        $this->db->delete('master_rekananshipping');
        
    }







    
    
    // get ar_alloc_ari
    public function combo_branch() 
    {
      
        $result = $this->db->get('master_branch')
                           ->result();

        $ret ['']= 'Pilih Branch :';
        if($result)
        {
            foreach ($result as $key => $row)
            {
                $ret [$row->branch_id] = $row->branch_name;
            }
        }
        
        return $ret;
    }
    // get combo_shipping_type
    public function combo_shipping_type() 
    {
      
        $result = $this->db->get('master_rekananshippingtype')
                           ->result();

        $ret ['']= 'Pilih Type :';
        if($result)
        {
            foreach ($result as $key => $row)
            {
                $ret [$row->rekananshippingtype_id] = $row->rekananshippingtype_name;
            }
        }
        
        return $ret;
    }


	public function get_line($rekanan_id)
	{
		// $this->db->select('rekananshipping_line');
		// $this->db->where('rekanan_id',$rekanan_id);
		// $this->db->order_by('rekananshipping_line','desc');
		// $result = $this->db->get('master_rekananshipping');\
		$query = "SELECT TOP 1 rekananshipping_line FROM master_rekananshipping WHERE rekanan_id = $rekanan_id ORDER BY rekananshipping_line DESC";
		$result = $this->db->query($query)->row_array();
		
		//echo $this->db->last_query();
		 
        return $result['rekananshipping_line'];
        
	}
	
	public function get_rekanan_listrik($rekanan_id,$rekananshipping_line) 
    {
        
		$result = $this->db->query("select A.*,B.utilitieskva_id,B.utilitieskva_name+'| lwbp: '+cast(utilitieskva_tariflwbp as nvarchar(400))+' | wbp: '+cast(utilitieskva_tarifwbp as nvarchar(400)) as utilitieskva_name
		from master_rekananutilitieslistrik as A
inner join master_utilitieskva as B on A.utilitieskva_id = B.utilitieskva_id  
where rekanan_id ='$rekanan_id' and rekananshipping_line = '$rekananshipping_line' ");
		
		return $result->result_array();
		
		//$query = $this->db->query('SELECT * FROM master_rekananutilitieslistrik where rekanan_id ='.$rekanan_id.' and rekananshipping_line = '.$rekananshipping_line.' ');  
        //$result =$query->row_array();
		 
        // if ($result ) 
        // {
            // return $result ;
        // } 
        // else 
        // {
            // return array();
        // }
		
    }
	public function get_rekanan_air($rekanan_id,$rekananshipping_line) 
    {
         
		$result = $this->db->query('SELECT * FROM master_rekananutilitiesair where rekanan_id ='.$rekanan_id.' and rekananshipping_line = '.$rekananshipping_line.' ');  
        return $result->result_array();
		 
         
		
    }
	public function get_rekanan_gas($rekanan_id,$rekananshipping_line) 
    {
         
		$result = $this->db->query('SELECT * FROM master_rekananutilitiesgas where rekanan_id ='.$rekanan_id.' and rekananshipping_line = '.$rekananshipping_line.' ');  
        return $result->result_array();
		 
         
		
    }
    public function get_utilitieskva_all($where)
	{
				 		
      $getUnit = "EXEC [MstMstUtilitieskva_Select] '' ";
      $query = $this->db->query($getUnit);      

      return $query->result();
        
	}
	public function get_branch_air($branch_id) 
    {
         
		$result = $this->db->query('SELECT * FROM master_branchutilitiesair where branch_id ='.$branch_id.' ');  
        return $result->result_array();
		 
         
		
    }
	
	public function get_branch_gas($branch_id) 
    {
        $sql = 'SELECT * FROM master_branchutilitiesgas where branch_id ='.$branch_id.' ';
		$result = $this->db->query($sql);  
		
		// echo var_dump($sql);exit;
        return $result->result_array();
		          		
    }
	
	public function get_branch_listrik($branch_id,$type) 
    {
         
		$result = $this->db->query('select A.*, B.utilitieskva_name  from master_branchutilitieslistrik as A inner join master_utilitieskva as B on A.utilitieskva_id = B.utilitieskva_id  where branch_id ='.$branch_id.' AND A.utilitieslistrik_issingglemeter = '.$type.'');  
        return $result->result_array();
		          		
    }



}
