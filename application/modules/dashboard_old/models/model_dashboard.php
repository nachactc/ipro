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
		if ($bln == 1)
		{
			$query = $this->db->query('
			SELECT * FROM(
			select a.region_id,a.branch_id,b.region_name,c.branch_name,d.rekanan_name,e.rekananshipping_name,a.agreement_id,a.agreement_startperiod, a.agreement_endperiod 
			from transaksi_agreement a
			left join master_region b on a.region_id = b.region_id
			left join master_branch c on a.branch_id = c.branch_id
			left join master_rekanan d on a.rekanan_id = d.rekanan_id
			left join master_rekananshipping e on a.rekanan_id = e.rekanan_id and a.rekananshipping_line = e.rekananshipping_line
			where CONVERT(date,agreement_endperiod,105) 
			between  CONVERT(date,GETDATE()+1,105)			
			and   CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+1,0)),105)
			union all
			select a.region_id,a.branch_id,b.region_name,c.branch_name,d.rekanan_name,e.rekananshipping_name,a.agreement_id,a.agreement_startperiod, a.agreement_endperiod 
			from transaksi_agreementtemp a
			left join master_region b on a.region_id = b.region_id
			left join master_branch c on a.branch_id = c.branch_id
			left join master_rekanan d on a.rekanan_id = d.rekanan_id
			left join master_rekananshipping e on a.rekanan_id = e.rekanan_id and a.rekananshipping_line = e.rekananshipping_line
			where CONVERT(date,agreement_endperiod,105) 
			between  CONVERT(date,GETDATE()+1,105)			
			and   CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+1,0)),105)
			) as one
			order by region_id asc'); 
		}
		elseif($bln==3)
		{
			$query = $this->db->query('
			SELECT * FROM(
			select a.region_id,a.branch_id,b.region_name,c.branch_name,d.rekanan_name,e.rekananshipping_name,a.agreement_id,a.agreement_startperiod, a.agreement_endperiod 
			from transaksi_agreement a
			left join master_region b on a.region_id = b.region_id
			left join master_branch c on a.branch_id = c.branch_id
			left join master_rekanan d on a.rekanan_id = d.rekanan_id
			left join master_rekananshipping e on a.rekanan_id = e.rekanan_id and a.rekananshipping_line = e.rekananshipping_line
			where CONVERT(date,agreement_endperiod,105) 
			 between  CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+2,0)),105) 			
			 and   CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+3,0)),105)
			union all
			select a.region_id,a.branch_id,b.region_name,c.branch_name,d.rekanan_name,e.rekananshipping_name,a.agreement_id,a.agreement_startperiod, a.agreement_endperiod 
			from transaksi_agreementtemp a
			left join master_region b on a.region_id = b.region_id
			left join master_branch c on a.branch_id = c.branch_id
			left join master_rekanan d on a.rekanan_id = d.rekanan_id
			left join master_rekananshipping e on a.rekanan_id = e.rekanan_id and a.rekananshipping_line = e.rekananshipping_line
			where CONVERT(date,agreement_endperiod,105) 
			 between  CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+2,0)),105) 			
			 and   CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+3,0)),105)
			) as one
			order by region_id asc');  
		}
		elseif($bln==6)
		{
			$query = $this->db->query('
			SELECT * FROM(
			select a.region_id,a.branch_id,b.region_name,c.branch_name,d.rekanan_name,e.rekananshipping_name,a.agreement_id,a.agreement_startperiod, a.agreement_endperiod 
			from transaksi_agreement a
			left join master_region b on a.region_id = b.region_id
			left join master_branch c on a.branch_id = c.branch_id
			left join master_rekanan d on a.rekanan_id = d.rekanan_id
			left join master_rekananshipping e on a.rekanan_id = e.rekanan_id and a.rekananshipping_line = e.rekananshipping_line
			where CONVERT(date,agreement_endperiod,105) 
			 between  CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+4,0)),105) 			
			 and   CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+6,0)),105)
			union all
			select a.region_id,a.branch_id,b.region_name,c.branch_name,d.rekanan_name,e.rekananshipping_name,a.agreement_id,a.agreement_startperiod, a.agreement_endperiod 
			from transaksi_agreementtemp a
			left join master_region b on a.region_id = b.region_id
			left join master_branch c on a.branch_id = c.branch_id
			left join master_rekanan d on a.rekanan_id = d.rekanan_id
			left join master_rekananshipping e on a.rekanan_id = e.rekanan_id and a.rekananshipping_line = e.rekananshipping_line
			where CONVERT(date,agreement_endperiod,105) 
			 between  CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+4,0)),105) 			
			 and   CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+6,0)),105)
			) as one 
			order by region_id asc');  
		}
		elseif($bln==12)
		{
			$query = $this->db->query('
			SELECT * FROM(
			select a.region_id,a.branch_id,b.region_name,c.branch_name,d.rekanan_name,e.rekananshipping_name,a.agreement_id,a.agreement_startperiod, a.agreement_endperiod 
			from transaksi_agreement a
			left join master_region b on a.region_id = b.region_id
			left join master_branch c on a.branch_id = c.branch_id
			left join master_rekanan d on a.rekanan_id = d.rekanan_id
			left join master_rekananshipping e on a.rekanan_id = e.rekanan_id and a.rekananshipping_line = e.rekananshipping_line
			 where CONVERT(date,agreement_endperiod,105) 
			 between  CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+7,0)),105) 			
			 and   CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+12,0)),105) 
			union all
			select a.region_id,a.branch_id,b.region_name,c.branch_name,d.rekanan_name,e.rekananshipping_name,a.agreement_id,a.agreement_startperiod, a.agreement_endperiod 
			from transaksi_agreementtemp a
			left join master_region b on a.region_id = b.region_id
			left join master_branch c on a.branch_id = c.branch_id
			left join master_rekanan d on a.rekanan_id = d.rekanan_id
			left join master_rekananshipping e on a.rekanan_id = e.rekanan_id and a.rekananshipping_line = e.rekananshipping_line
			 where CONVERT(date,agreement_endperiod,105) 
			 between  CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+7,0)),105) 			
			 and   CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+12,0)),105) 
			) as one
			order by region_id asc');  
		}
		else
		{
		  redirect ("dashboard");
		}	
		 
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
	
    /**
     *  Get All data Reminder 1 bulan 
     *
     *  @return array 
     */
    public function get_reminder1bln() 
    { 
		$query = $this->db->query('
		 SELECT SUM(jml) as jml FROM(
		 select count(agreement_endperiod) as jml from transaksi_agreement
		 where CONVERT(date,agreement_endperiod,105) 
		 between  CONVERT(date,GETDATE()+1,105)			
		 and   CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+1,0)),105)
		 union all
		 select count(agreement_endperiod) as jml from transaksi_agreementtemp
		 where CONVERT(date,agreement_endperiod,105) 
		 between  CONVERT(date,GETDATE()+1,105)			
		 and   CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+1,0)),105)
		 ) as one');  
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
	
	 
	
    /**
     *  Get All data Reminder 3 bulan 
     *
     *  @return array 
     */
    public function get_reminder3bln() 
    { 
		$query = $this->db->query('
		 SELECT SUM(jml) as jml FROM(
		 select count(agreement_endperiod)  as jml from transaksi_agreement
		 where CONVERT(date,agreement_endperiod,105) 
		 between  CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+2,0)),105) 			
		 and   CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+3,0)),105)
		 union all
		 select count(agreement_endperiod)  as jml from transaksi_agreementtemp
		 where CONVERT(date,agreement_endperiod,105) 
		 between  CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+2,0)),105) 			
		 and   CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+3,0)),105)
		 ) as three ');  
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
    
     
   
   /**
     *  Get All data Reminder 6 bulan 
     *
     *  @return array 
     */
    public function get_reminder6bln() 
    { 
		$query = $this->db->query('
		 SELECT SUM(jml) as jml FROM(
		 select count(agreement_endperiod)  as jml  from transaksi_agreement
		 where CONVERT(date,agreement_endperiod,105) 
		 between  CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+4,0)),105) 			
		 and   CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+6,0)),105)
		union all
		select count(agreement_endperiod)  as jml  from transaksi_agreementtemp
		 where CONVERT(date,agreement_endperiod,105) 
		 between  CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+4,0)),105) 			
		 and   CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+6,0)),105) 
		) as six');  
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
     
	
	/**
     *  Get All data Reminder 12 bulan 
     *
     *  @return array 
     */
    public function get_reminder12bln() 
    { 
		$query = $this->db->query(' 
		 SELECT SUM(jml) as jml FROM(
		 select count(agreement_endperiod )  as jml   from transaksi_agreement	
		 where CONVERT(date,agreement_endperiod,105) 
		 between  CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+7,0)),105) 			
		 and   CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+12,0)),105)
		  union all
		  select count(agreement_endperiod )  as jml   from transaksi_agreementtemp	
		 where CONVERT(date,agreement_endperiod,105) 
		 between  CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+7,0)),105) 			
		 and   CONVERT(date,DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())+12,0)),105) 
		 ) as one_year');  
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
	
	public function get_dataApproveLoo($region) 
    { 
		$query = $this->db->query(" 
		SELECT count(*) as jml 
		FROM transaksi_loo
		where isdisabled = 0
		and isapproved = 1
		and YEAR(loo_date) = YEAR(GETDATE())
		and region_id = '$region' ");  
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
	
	public function get_dataBaruLoo($region) 
    { 
		$query = $this->db->query(" 
		SELECT COUNT(*) as jml FROM transaksi_loo
		where isdisabled = 0
		and isapproved = 0
		and YEAR(loo_date) = YEAR(GETDATE()) 
		and region_id = '$region' ");  
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
	
	public function get_allDataBaruLoo($region) 
    { 
		$query = $this->db->query(" 
		SELECT COUNT(*) as jml FROM transaksi_loo
		where isdisabled = 0 
		and YEAR(loo_date) = YEAR(GETDATE()) 
		and region_id = '$region' ");  
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
	
	public function get_dataLoiProcess($region) 
    { 
		$query = $this->db->query(" 
		select COUNT(a.loo_id) as jml 
		from transaksi_loireceived	a
		inner join transaksi_loo b on a.loo_id = b.loo_id
		where region_id = '$region' 
		--120 Trans Ritel Properti -- 030 --Trans Retail Indonesia --050 --Alfa Retailindo Indonesia
		and a.loi_isprocess = 1
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

	public function get_dataLoiSent($region) 
    { 
		$query = $this->db->query(" 
		--data loi sent
		select COUNT(a.loo_id)  as jml
		from transaksi_loireceived	a
		inner join transaksi_loo b on a.loo_id = b.loo_id
		where region_id = '$region' 
		--120 Trans Ritel Properti -- 030 --Trans Retail Indonesia --050 --Alfa Retailindo Indonesia
		and a.loi_issent = 1 
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
	
	public function get_dataLoiSign($region) 
    { 
		$query = $this->db->query(" 
		--data loi sign
		select COUNT(a.loo_id)  as jml
		from transaksi_loireceived	a
		inner join transaksi_loo b on a.loo_id = b.loo_id
		where region_id = '$region' 
		--120 Trans Ritel Properti -- 030 --Trans Retail Indonesia --050 --Alfa Retailindo Indonesia
		and a.loi_issigned = 1 
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
	
	public function get_dataLoiReceived($region) 
    { 
		$query = $this->db->query("  
		select COUNT(a.loo_id) as jml
		from transaksi_loireceived	a
		inner join transaksi_loo b on a.loo_id = b.loo_id
		where b.region_id = '$region'  
		and a.loi_isreceived = 1 
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
			select  (invoice_id)
			from transaksi_schedulepaymentdetil
			where schedulepaymentdetil_isproforma = 1
			and	  schedulepaymentdetil_ischecked = 1
			and agreementtype_id not in (select agreementtype_id from master_agreementtype where agreementtype_type IN ('DEPOSIT','LOAN'))
			and month(schedulepaymentdetil_proformadate) = MONTH(GETDATE())
			group by invoice_id
			) v");	 
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
	
	public function get_status_payment_invoice_2()
	{
		$query = $this->db->query("
		WITH SP (jurnal_id)
		as
		( select jurnal_id 
					from transaksi_jurnal
					where jurnal_id IN (  
						select schedulepayment_id+CAST(schedulepaymentdetil_line as nvarchar(5)) as id
						from transaksi_schedulepaymentdetil
						where schedulepaymentdetil_ischecked = 1
						and schedulepaymentdetil_isposted = 1
						and agreementtype_id in (select agreementtype_id from master_agreementtype where agreementtype_type IN ('DEPOSIT','LOAN'))
						and convert(date,schedulepaymentdetil_posteddate ,105)
						between CONVERT(date,DATEADD(month, DATEDIFF(month, 0, DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,-1,GETDATE())-3,-1)) ), 0),105) 
						and CONVERT(date,GETDATE(),105)
						group by schedulepayment_id,schedulepaymentdetil_line    
					)
					and jurnal_isposted = 1  
		)
		 select count(b.jurnal_id) as outstanding,
		 SUM(b.jurnaldetil_idr) as total_outstanding
		 from SP a
		 LEFT JOIN transaksi_jurnaldetil b on b.jurnal_id = a.jurnal_id 
		 LEFT JOIN transaksi_jurnal c on b.jurnal_id = c.jurnal_id    
		 where isnull(b.ref_id,'') = ''
		 and b.jurnaldetil_dk = 'D' ");
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
