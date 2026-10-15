<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Model_dashboard extends CI_Model 
{
	Protected $id_rekanan = 0;
	
    public function __construct() 
    {
        parent::__construct();
    }


    /**
     *  Get All data Reminder 1 bulan detil
     *
     *  @return array 
     */
    public function get_reminderbln_detil($bln) 
    { 
        $query = $this->db->query("lm03_Dashboard_Reminder_Detil {$bln}");
		 
        $result = $query->result_array();
		 
        if ($result ) 
        {
            return $result;
        } 
        else 
        {
            return array();
        }
    }
	
    /**
     *  Get All data Reminder 1 bulan 
     *
     *  @return array 
     */
    public function getReminderBln($bln) 
    {         
		$query = $this->db->query("lm03_Dashboard_Reminder_Count {$bln}");  
        $result =$query->row();
		 
        if ($result ) 
        {
            return $result->jml ;
        } 
        else 
        {
            return array();
        }
		
    }
	
	public function get_dataApproveLoo() 
    { 
		$query = $this->db->query(" 
		SELECT count(*) as jml 
		FROM transaksi_loo
		where isdisabled = 0
		and isapproved = 1
		and YEAR(loo_date) = YEAR(GETDATE())
		");  
        $result =$query->row();
		 
        if ($result ) 
        {
            return $result->jml ;
        } 
        else 
        {
            return array();
        }
		
    }
	
	public function get_dataBaruLoo() 
    { 
		$query = $this->db->query(" 
		SELECT COUNT(*) as jml FROM transaksi_loo
		where isdisabled = 0
		and isapproved = 0
		and YEAR(loo_date) = YEAR(GETDATE()) 
		");  
        $result =$query->row();
		 
        if ($result ) 
        {
            return $result->jml ;
        } 
        else 
        {
            return array();
        }
		
    } 
	
	public function get_allDataBaruLoo() 
    { 
		$query = $this->db->query(" 
		SELECT COUNT(*) as jml FROM transaksi_loo
		where isdisabled = 0 
		and YEAR(loo_date) = YEAR(GETDATE()) 
		");  
        $result =$query->row();
		 
        if ($result ) 
        {
            return $result->jml ;
        } 
        else 
        {
            return array();
        }
		
    } 
	
	public function get_dataLoiProcess() 
    { 
		$query = $this->db->query(" 
		select COUNT(a.loo_id) as jml 
		from transaksi_loireceived	a
		inner join transaksi_loo b on a.loo_id = b.loo_id
		where a.loi_isprocess = 1
		and YEAR(b.loo_date) = YEAR(GETDATE()) ");  
        $result =$query->row();
		 
        if ($result ) 
        {
            return $result->jml ;
        } 
        else 
        {
            return array();
        }
		
    }

	public function get_dataLoiSent() 
    { 
		$query = $this->db->query(" 
		--data loi sent
		select COUNT(a.loo_id)  as jml
		from transaksi_loireceived	a
		inner join transaksi_loo b on a.loo_id = b.loo_id
		where a.loi_issent = 1 
		and YEAR(b.loo_date) = YEAR(GETDATE())");  
        $result =$query->row();
		 
        if ($result ) 
        {
            return $result->jml ;
        } 
        else 
        {
            return array();
        }
		
    }
	
	public function get_dataLoiSign() 
    { 
		$query = $this->db->query(" 
		--data loi sign
		select COUNT(a.loo_id)  as jml
		from transaksi_loireceived	a
		inner join transaksi_loo b on a.loo_id = b.loo_id
		where a.loi_issigned = 1 
		and YEAR(b.loo_date) = YEAR(GETDATE())");  
        $result =$query->row();
		 
        if ($result ) 
        {
            return $result->jml ;
        } 
        else 
        {
            return array();
        }
		
    }
	
	public function get_dataLoiReceived() 
    { 
		$query = $this->db->query("  
		select COUNT(a.loo_id) as jml
		from transaksi_loireceived	a
		inner join transaksi_loo b on a.loo_id = b.loo_id
		where a.loi_isreceived = 1 
		and YEAR(b.loo_date) = YEAR(GETDATE())");  
        $result =$query->row();
		 
        if ($result ) 
        {
            return $result->jml ;
        } 
        else 
        {
            return array();
        }
		
    }
	
	public function get_sumDP_Secdep($region_id)
	{
		$stored_pocedure = "EXEC Rpt03_Select_Tenant_SumShopMall '$region_id'";
		$result = $this->db->query($stored_pocedure); 
		return $result->row(); 
	}
	
	public function get_unitStatus($region_id,$status)
	{
		$query = $this->db->query("  
		select count(unit_state) as jml
		from master_unit
		where unit_state = $status
		and region_id = '$region_id'");  
        $result =$query->row();
		 
        if ($result ) 
        {
            return $result->jml ;
        } 
        else 
        {
            return array();
        }
		
		
	}
    
	public function get_status_empty($table,$column,$AndCriteria='')
	{
		// echo $table."<br/>";
		// echo $column."<br/>";
		// echo $AndCriteria."<br/>";
		$query = $this->db->query("  
		select count($column) as jml 
		from $table
		where ISNULL($column,'') = ''
		$AndCriteria");  
        $result =$query->row();
		//echo $this->db->last_query();
		 
        if ($result ) 
        {
            return $result->jml ;
        } 
        else 
        {
            return array();
        }
		
	}
	
	public function get_status_empty_detil($table,$view,$column,$AndCriteria='')
	{
		$query = $this->db->query("  
		select $view
		from $table
		where ISNULL($column,'') = ''
		$AndCriteria");  
        $result =$query->result_array();
		 
        if ($result ) 
        {
            return $result;
        } 
        else 
        {
            return array();
        }
		
	}
	
	public function get_status_agreement_posting($old_month=0)
	{ 
		if($old_month == 0)
		{
			$query = $this->db->query("SELECT SUM(jml) AS jml
			    FROM (
				select count(agreement_isapproved) as jml 
				from transaksi_agreement
				where agreement_isapproved = 1
				and MONTH(agreement_createdate) = MONTH(getdate())
				and YEAR(agreement_createdate) = YEAR(getdate())
				union all
				select count(agreement_isapproved) as jml
				from transaksi_agreementtemp
				where agreement_isapproved = 1
				and MONTH(agreement_createdate) = MONTH(getdate())
				and YEAR(agreement_createdate) = YEAR(getdate())
				) as V	"); 
		}
		elseif($old_month == 1)
		{
			$query = $this->db->query("
					SELECT SUM(jml) AS jml FROM (
					select count(agreement_isapproved) as jml 
					from transaksi_agreement
					where agreement_isapproved = 1
					and MONTH(agreement_createdate) = MONTH(getdate())-1
					and YEAR(agreement_createdate) =  year(DATEADD(MONTH, DATEDIFF(MONTH, 1, GETDATE()), -1) )
					union all
					select count(agreement_isapproved) as jml
					from transaksi_agreementtemp
					where agreement_isapproved = 1
					and MONTH(agreement_createdate) = MONTH(getdate())-1
					and YEAR(agreement_createdate) =  year(DATEADD(MONTH, DATEDIFF(MONTH, 1, GETDATE()), -1) )
					) as V");	 
		}
		
		// echo "<pre>".$query ;
		// exit;
		
		 
	    if($query->num_rows() == 1) // if the affected number of rows is one---LINE 19---
	    {
			$result = $query->row();
            return $result->jml ;
        } 
        else 
        {
            return array();
        }
		
	}
	
	public function get_status_invoice($proforma=0)
	{
		if($proforma == 0)
		{
			$query = $this->db->query("--non   proforma  
			SELECT COUNT(id) as jml FROM 
			(
			select invoice_id as id
			from transaksi_schedulepaymentdetil
			where schedulepaymentdetil_ischecked = 1
			and schedulepaymentdetil_isposted = 1
			and agreementtype_id in (select agreementtype_id from master_agreementtype where agreementtype_type IN ('DEPOSIT','LOAN'))
			and month(schedulepaymentdetil_posteddate) = MONTH(GETDATE())
			group by invoice_id
			union all
			select   faktur_id as id
			from transaksi_schedulepaymentdetil
			where schedulepaymentdetil_ischecked = 1
			and schedulepaymentdetil_isposted = 1
			and agreementtype_id not in (select agreementtype_id from master_agreementtype where agreementtype_type IN ('DEPOSIT','LOAN'))
			and month(schedulepaymentdetil_posteddate) = MONTH(GETDATE())
			group by faktur_id
			) v"); 
		}
		elseif($proforma == 1)
		{
			$query = $this->db->query("
					--proforma
		 	SELECT COUNT(invoice_id) as jml FROM 
			(		
			  select (invoice_id+agreementtype_id) as invoice_id
						from transaksi_schedulepaymentdetil
						where schedulepaymentdetil_ischecked = 1
						and convert(date,schedulepaymentdetil_proformadate ,105)
						between CONVERT(date,DATEADD(month, DATEDIFF(month, 0, DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())-3,-1)) ), 0),105) 
						and CONVERT(date,GETDATE(),105)
						group by invoice_id,agreementtype_id 
			)G");	 
		}
		
		// echo "<pre>".$query ;
		// exit;
		
		 
	    if($query->num_rows() == 1) // if the affected number of rows is one---LINE 19---
	    {
			$result = $query->row();
            return $result->jml ;
        } 
        else 
        {
            return array();
        }
	}
	
	public function get_status_loi()
	{
		$query = $this->db->query("select COUNT(agreement_id) as jml 
				from v_agreement
				where agreement_isapproved = 0
				and month(agreement_createdate) = month(GETDATE())
				and YEAR(agreement_createdate)= YEAR(GETDATE())");
		if($query->num_rows() == 1) // if the affected number of rows is one---LINE 19---
	    {
			$result = $query->row();
            return $result->jml ;
        } 
        else 
        {   
			return array();
        }
	}
	
	public function get_jumlah_tenant()
	{
		$query = $this->db->query("select COUNT(a.rekananshipping_name) as jml 
								from master_rekananshipping a
								inner join master_rekanan b on a.rekanan_id = b.rekanan_id
								where rekanan_isdisabled = 0  and a.rekananshipping_isactive = 1");
								
								// select COUNT(a.rekananshipping_name) as jml 
								// from master_rekananshipping a
								// inner join master_rekanan b on a.rekanan_id = b.rekanan_id
								// where rekanan_isdisabled = 0  and a.rekananshipping_isactive = 1
		if($query->num_rows() == 1) // if the affected number of rows is one---LINE 19---
	    {
			$result = $query->row();
            return $result->jml ;
        } 
        else 
        {   
			return array();
        }
	}

	public function get_jumlah_brand()
	{
		$query = $this->db->query("select COUNT(a.rekananshipping_name) as jml 
from master_rekananshipping a
inner join v_agreement c on c.rekanan_id = a.rekanan_id and c.rekananshipping_line = a.rekananshipping_line
inner join master_rekanan b on a.rekanan_id = b.rekanan_id
where rekanan_isdisabled = 0  and a.rekananshipping_isactive = 1");
								
		if($query->num_rows() == 1) // if the affected number of rows is one---LINE 19---
	    {
			$result = $query->row();
            return $result->jml ;
        } 
        else 
        {   
			return array();
        }
	}
	
	public function get_status_payment_invoice()
	{
	    $date = date('Y-m-d'); 
		$stored_pocedure = "EXEC cp_RptIPRO_PaymentInvoice'$date'";
		$result = $this->db->query($stored_pocedure); 
	 
	 
		if($result->num_rows() == 1) // if the affected number of rows is one---LINE 19---
	    { 
            return $result->row();
        } 
        else 
        {   
			return array();
        } 
	}
	
	public function get_status_payment_invoice_2()//outstanding calculate
	{
			// and convert(date,schedulepaymentdetil_proformadate ,105)
						// between CONVERT(date,DATEADD(month, DATEDIFF(month, 0, DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())-3,-1)) ), 0),105) 
						// and CONVERT(date,GETDATE(),105)
		$query = $this->db->query("EXEC cp_RptIPRO_PaymentInvoice_Outstanding");
		
		if($query->num_rows() == 1) // if the affected number of rows is one---LINE 19---
	    {
			$result = $query->row();
			
            return $result;
        } 
        else 
        {   
			return array();
        } 
	}
	
}
