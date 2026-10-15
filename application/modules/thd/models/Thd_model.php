<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
class Thd_model extends CI_Model 
{

    public function __construct() 
    {
        parent::__construct();
    }

	// get branch
    public function get_branch($branch_name,$region_id) 
    {
        $result =  $this->db->query("SELECT a.branch_id,a.branch_name,a.branch_isgroup
		from master_branch a 
		left join master_regionbranch b on a.branch_id = b.branch_id WHERE a.branch_isgroup = 0 and b.region_id = $region_id and a.branch_name like '%$branch_name%'") ->result();
		// $this->db->where('branch_isgroup',0);
        // $result = $this->db->get('master_branch')
                           // ->result();

        // $ret ['']= 'Pilih Store :';
        // if($result)
        // {
            // foreach ($result as $key => $row)
            // {
                // $ret [$row->branch_id] = $row->branch_name;
            // }
        // }
        
        return $result;
    }
	// get region
    public function get_region()
    {
       
        $result = $this->db->get('master_region')
                           ->result();

        $ret ['']= 'Pilih Business Unit :';
        if($result)
        {
            foreach ($result as $key => $row)
            {
                $ret [$row->region_id] = $row->region_name;
            }
        }
        
        return $ret;
    }

    public function getDataThdLeasing($criteria)
    {        
      $sql = "EXEC lm03_RptTHD '{$criteria->rptDate}', '{$criteria->region_id}', '{$criteria->branch_id}'";
      $this->db->query($sql);
      
      $sql = " select * from ##TEMP_THD ";
      $result = $this->db->query($sql);

      return $result->result();
    }	 


    public function getDataThdTermination($criteria)
    {
      $stored_pocedure = "EXEC lm03_RptTHDTermination '{$criteria->rptDate}', '{$criteria->region_id}', '{$criteria->branch_id}'";
      //echo $stored_pocedure;exit;
      $result = $this->db->query($stored_pocedure); 
      return $result->result();
    }
	
    public function getDataThdSummary($criteria)
    {    
        $result = new \stdClass;

        $sql = "EXEC lm03_RptTHD '{$criteria->rptDate}', '{$criteria->region_id}', '{$criteria->branch_id}'";
        //echo $stored_pocedure;exit;
        $this->db->query($sql);

        $total = $this->getTotal();
        $totalTypes = $this->getTotalType();
        $dataRowTypes = $this->getThdByTypes();
        $dataRowCategories = $this->getThdByCategoryAll();

        $result->total = $total;
        $result->totalTypes = $totalTypes;
        $result->dataRowTypes = $dataRowTypes;
        $result->dataRowCategories = $dataRowCategories;
        return $result;
    }	 

    public function getTotal()
    {		
      $sql = "
         select
           sum(nla) as total_nla
           , sum(amount) as total_amount
         from
         (
            select
              case when amount_ps > 0 then (amount_ps-discount_in) else (amount_in-discount_in) end as amount
              , agreementdetil_space as nla
            from 
            ##TEMP_THD
         ) thdtype
      ";
      $result = $this->db->query($sql);

		  return $result->row_array();
    }	     

    public function getTotalType()
    {		
      $sql = "
         select 
           thdtype_name
           , sum(nla) as total_nla
           , sum(amount) as total_amount
         from
         (
            select  
              thdtype_name
              , case when amount_ps > 0 then (amount_ps-discount_in) else (amount_in-discount_in) end as amount
              , agreementdetil_space as nla
            from 
              ##TEMP_THD
         ) thdtype
         group by 
           thdtype_name
      ";
      $result = $this->db->query($sql);

		  return $result->result_array();
    }

    public function getThdByCategoryAll()
    {		
      $sql = "
         select
           thdcat_name
           , sum(nla) as total_nla
           , sum(amount) as total_amount
         from
         (
            select
              thdcat_name
              , case when amount_ps > 0 then (amount_ps-discount_in) else (amount_in-discount_in) end as amount
              , agreementdetil_space as nla
            from 
            ##TEMP_THD
         ) thdcat
         group by 
           thdcat_name
         order by 
           thdcat_name
      ";
      $result = $this->db->query($sql);

		  return $result->result_array();
    }

    public function getThdByTypes()
    {		
      $sql = "
         select 
           thdtype_name
           , thdcat_name
           , sum(nla) as total_nla
           , sum(amount) as total_amount
         from
         (
            select  
              thdtype_name
              , thdcat_name
              , case when amount_ps > 0 then (amount_ps-discount_in) else (amount_in-discount_in) end as amount
              , agreementdetil_space as nla
            from 
            ##TEMP_THD
         ) thdcat
         group by 
           thdtype_name
           , thdcat_name
         order by 
           thdtype_name
      ";
      $result = $this->db->query($sql);

		  return $result->result_array();
    }

    public function getDataThdInvoice($criteria)    
    {

      $sql = "EXEC lm03_RptTHD_Amount '{$criteria->rptDate}', '{$criteria->region_id}', '{$criteria->branch_id}'";
      $this->db->query($sql);
      
      $sql = " select * from ##THD_Invoice ";
      $result = $this->db->query($sql);
      
      return $result->result();
    }	 


    public function getDataThdInvoiceSummary($criteria)
    {    
        $result = new \stdClass;

        $sql = "EXEC lm03_RptTHD_Amount '{$criteria->rptDate}', '{$criteria->region_id}', '{$criteria->branch_id}'";
        $this->db->query($sql);

        $total = $this->getTotalInvoice();
        $totalTypes = $this->getTotalTypeInvoice();
        $dataRowTypes = $this->getThdByTypeInvoice();
        $dataRowCategories = $this->getThdByCategoryInvoice();

        $result->total = $total;
        $result->totalTypes = $totalTypes;
        $result->dataRowTypes = $dataRowTypes;
        $result->dataRowCategories = $dataRowCategories;
        return $result;
    }	 



    public function getTotalInvoice()
    {		
      $sql = "
          select
            sum(schedulepaymentdetil_idr) as total_amount
            , sum(agreementdetil_space) as total_nla
          from 
            ##THD_Invoice
      ";
      $result = $this->db->query($sql);

		  return $result->row_array();
    }	     

    public function getTotalTypeInvoice()
    {		
      $sql = "
          select
            thdtype_name
            , sum(schedulepaymentdetil_idr) as total_amount
            , sum(agreementdetil_space) as total_nla
          from 
            ##THD_Invoice
          group by 
            thdtype_name
      ";
      $result = $this->db->query($sql);

		  return $result->result_array();
    }

    public function getThdByCategoryInvoice()
    {		
      $sql = "         
          select
            thdcat_name
            , sum(schedulepaymentdetil_idr) as total_amount
            , sum(agreementdetil_space) as total_nla
          from 
            ##THD_Invoice
          group by 
            thdcat_name
          order by 
            thdcat_name
      ";
      $result = $this->db->query($sql);

		  return $result->result_array();
    }

    public function getThdByTypeInvoice()
    {		
      $sql = "
          select
            thdtype_name
            , thdcat_name
            , sum(schedulepaymentdetil_idr) as total_amount
            , sum(agreementdetil_space) as total_nla
          from 
            ##THD_Invoice
          group by 
            thdtype_name
            , thdcat_name
          order by 
            thdtype_name
      ";
      $result = $this->db->query($sql);

		  return $result->result_array();
    }



    public function getDataThdCasual($criteria)    
    {        
      $stored_pocedure = "EXEC lm03_RptTHDCasual '{$criteria->rptDate}', '{$criteria->region_id}', '{$criteria->branch_id}'";
      //echo $stored_pocedure;exit;
      $result = $this->db->query($stored_pocedure); 
      return $result->result();
    }	          

    public function get_branch_info($branch_id)
    { 
      
      $result =  $this->db->query("SELECT a.branch_id,a.branch_name,b.region_id,c.region_namereport,a.branch_openingdate
      from master_branch a 
      left join master_regionbranch b on a.branch_id = b.branch_id 
      left join master_region c on b.region_id = c.region_id
      WHERE a.branch_isgroup = 0 and   a.branch_id =  '$branch_id'") ;
      if($result->num_rows() > 0)
      {
        return $result->row();
      }
      else
      {
        return 'kosong';
      }
      
    }
    
    function get_branch_dlg($branch_name="")
    {  
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
        return $result; 
      
    }
    
    public function get_region_dlg() 
    {
        
        $result = $this->db->get('master_region')
                            ->result();

        // $ret ['']= 'Pilih Business Unit :';
        // if($result)
        // {
            // foreach ($result as $key => $row)
            // {
                // $ret [$row->region_id] = $row->region_name;
            // }
        // }
        
        return $result;
    }
	
}
