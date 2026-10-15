<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
  
class rekananshipping_model extends CI_Model 
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
         
        $query = $this->db->query('	
                    SELECT
                        ship.rekanan_id
                        ,ship.rekananshipping_line
                        ,ship.rekananshipping_name
                        ,ship.rekananshipping_namereport
                        ,ship.branch_id
                        ,ship.rekanan_id
                        ,ship.rekananshipping_isactive
                        ,thd.thdcat_id
                        ,thd.thdgroup_id
                        ,thd.thdtype_id
                        ,thd.thdlt_id
                        ,thd.rekananthd_mg
                        ,thd.rekananthd_comterms
                        ,thd.rekananthd_remarks
                    FROM master_rekananshipping ship 
                    left join master_rekananthd thd on ship.rekanan_id = thd.rekanan_id and ship.rekananshipping_line = thd.rekananshipping_line
                    WHERE ship.rekanan_id ='.$rekanan_id.' and ship.rekananshipping_line = '.$rekananshipping_line.' 
        ');  

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
    public function save($rekanan_id, $rekananshipping_line) 
    {
				$thdgroup_id = $this->input->post('thdgroup_id');
				$thdtype_id = $this->input->post('thdtype_id');
				$thdcat_id = $this->input->post('thdcat_id');
				$thdlt_id = $this->input->post('thdlt_id');
				$rekananthd_mg = $this->input->post('rekananthd_mg');
				$rekananthd_comterms = $this->input->post('rekananthd_comterms');
				$rekananthd_remarks = $this->input->post('rekananthd_remarks');

				$thdgroup_id = empty($thdgroup_id) ? null : $thdgroup_id;
				$thdtype_id = empty($thdtype_id) ? null : $thdtype_id;
				$thdcat_id = empty($thdcat_id) ? null : $thdcat_id;
				$thdlt_id = empty($thdlt_id) ? null : $thdlt_id;

                $rekananthd_mg = str_replace(',', '',$rekananthd_mg);

				$data = array(
					'rekanan_id' => $rekanan_id,
					'rekananshipping_line' => $rekananshipping_line,
					'thdgroup_id' => $thdgroup_id,
					'thdcat_id' => $thdcat_id,
					'thdlt_id' => $thdlt_id,
					'thdtype_id' => $thdtype_id,
                    'rekananthd_mg' => $rekananthd_mg,
                    'rekananthd_comterms' => $rekananthd_comterms,
                    'rekananthd_remarks' => $rekananthd_remarks
				);
				
				$this->db->where('rekanan_id', $rekanan_id);
				$this->db->where('rekananshipping_line', $rekananshipping_line);
				$this->db->delete('master_rekananthd');


				$this->db->insert('master_rekananthd', $data);
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
		

			$data = array(

				//'rekananshipping_contactname' => strip_tags($this->input->post('rekananshipping_contactname', TRUE)),
				'thdgroup_id' => strip_tags($this->input->post('thdtype_id', TRUE)),
				'thdcat_id' => strip_tags($this->input->post('thdcat_id', TRUE)),
				'thdtype_id' => strip_tags($this->input->post('thdgroup_id', TRUE))
			);

				
			$this->db->where('rekanan_id', $id_rekanan);
			$this->db->where('rekananshipping_line', $rekananshipping_line);
			$this->db->update('master_rekananthd', $data);

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

		// get combo_thd_type
    public function combo_thd_type() 
    {
      
        $result = $this->db->get('master_thdtype')
                           ->result();

        $ret ['']= 'Pilih Type :';
        if($result)
        {
            foreach ($result as $key => $row)
            {
                $ret [$row->thdtype_id] = $row->thdtype_name;
            }
        }
        
        return $ret;
    }

		// get combo_thd_group
    public function combo_thd_group() 
    {
      
        $result = $this->db->get('master_thdgroup')
                           ->result();

        $ret ['']= 'Pilih Group :';
        if($result)
        {
            foreach ($result as $key => $row)
            {
                $ret [$row->thdgroup_id] = $row->thdgroup_name;
            }
        }
        
        return $ret;
    }

		// get combo_thd_cat
    public function combo_thd_cat() 
    {
      
        $result = $this->db->get('master_thdcat')
                           ->result();

        $ret ['']= 'Pilih Kategori :';
        if($result)
        {
            foreach ($result as $key => $row)
            {
                $ret [$row->thdcat_id] = $row->thdcat_name;
            }
        }
        
        return $ret;
    }

    // get combo_thd_lt
    public function combo_thd_lt() 
    {
    
        $result = $this->db->get('master_thdlt')
                        ->result();

        $ret ['']= 'Pilih Lantai :';
        if($result)
        {
            foreach ($result as $key => $row)
            {
                $ret [$row->thdlt_id] = $row->thdlt_name;
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


}
