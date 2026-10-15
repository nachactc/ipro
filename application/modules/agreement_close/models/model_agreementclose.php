<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_agreementclose extends CI_Model{
    
    function __construct(){
        parent::__construct();
		check_user_login();
    }
	 
    function qry_alldatalist($limit,$top,$sWhere){
	// echo var_dump($sWhere);
     $sWhere = empty($sWhere) ? "WHERE a.agreement_isclosed = 0 and a.agreement_isapproved = 1" : "WHERE a.agreement_isapproved = 1 ".str_replace("WHERE","AND", $sWhere);

	   $qry=" 
			SELECT * FROM (
			select top $limit  ROW_NUMBER() OVER (ORDER BY a.agreement_id desc) as RowNumber, 
			b.region_name,c.branch_name,d.rekanan_name,e.rekananshipping_name,a.agreement_id,
			a.agreement_createdate,
			a.agreement_contractno,
			a.agreement_virtualaccount,
			a.agreement_startdate,
			a.agreement_enddate,
			a.agreement_term,
			a.agreement_dayterm,
			a.agreement_isclosed
			from v_agreement a
			left join master_region b on a.region_id = b.region_id
			left join master_branch c on a.branch_id = c.branch_id
			left join master_rekanan d on a.rekanan_id = d.rekanan_id
			left join master_rekananshipping e on a.rekanan_id = e.rekanan_id and a.rekananshipping_line = e.rekananshipping_line 
			 $sWhere
			 ORDER BY  a.agreement_id  asc
			  ) AS V
    	WHERE   RowNumber > $top";
	  
	   //echo $sWhere;
	   //exit;
	    return $this->db->query($qry)->result_array();
   }
   
    function qry_filteredlist($sWhere){ 
     $sWhere = empty($sWhere) ? "WHERE a.agreement_isclosed = 0 and a.agreement_isapproved = 1" : $sWhere." AND a.agreement_isclosed = 0 and a.agreement_isapproved = 1";
	   $qry="SELECT count(*) as jml FROM ( 
			select  
			b.region_name,c.branch_name,d.rekanan_name,e.rekananshipping_name,a.agreement_id,
			a.agreement_createdate,
			a.agreement_contractno,
			a.agreement_virtualaccount,
			a.agreement_startdate,
			a.agreement_enddate,
			a.agreement_term,
			a.agreement_dayterm
			from v_agreement a
			left join master_region b on a.region_id = b.region_id
			left join master_branch c on a.branch_id = c.branch_id
			left join master_rekanan d on a.rekanan_id = d.rekanan_id
			left join master_rekananshipping e on a.rekanan_id = e.rekanan_id and a.rekananshipping_line = e.rekananshipping_line 
			$sWhere 
			  ) AS V";
		return $this->db->query($qry)->row_array();
	   
   }
   
    function qry_totalalllist(){
	   $qry="SELECT count(*) as jml FROM ( 
			select   
			b.region_name,c.branch_name,d.rekanan_name,e.rekananshipping_name,a.agreement_id,
			a.agreement_createdate,
			a.agreement_contractno,
			a.agreement_virtualaccount,
			a.agreement_startdate,
			a.agreement_enddate,
			a.agreement_term,
			a.agreement_dayterm
			from v_agreement a
			left join master_region b on a.region_id = b.region_id
			left join master_branch c on a.branch_id = c.branch_id
			left join master_rekanan d on a.rekanan_id = d.rekanan_id
			left join master_rekananshipping e on a.rekanan_id = e.rekanan_id and a.rekananshipping_line = e.rekananshipping_line  
			WHERE a.agreement_isclosed = 0 and a.agreement_isapproved = 1 
			  ) AS V";
		return $this->db->query($qry)->row_array();
	   
   }
   
    function AgreementClose()
	{
		$agr_id = $this->input->post('agreement_id');
		$id = substr($agr_id, 0,2); 
		$closing_date = $this->input->post('closing_date');
		$closing_by = $this->session->userdata('username'); 
		$closing_reason = $this->input->post('closing_reason');
		$closing_desc = $this->input->post('closing_desc');
		$closing_desc = $closing_desc.' [ From IPRO | '.date('d-m-Y H:i:s',strtotime("now")).' ]';
		if($id == 'AT')
		{
			$qry="lm03_TrnAgreementtemp_Closing '$agr_id','$closing_date','$closing_by','$closing_reason','$closing_desc' ";
		}
		else
		{
			$qry="lm03_TrnAgreement_Closing '$agr_id','$closing_date','$closing_by','$closing_reason','$closing_desc' ";
		}
		//echo $qry;exit;
		$this->db->query($qry);
	}

	//**new**//
  
   function get_schedule($id){   

     if (isset($id)){
		  $agr_id = substr($id, 0,2); 
		if($agr_id == 'AT')
		{
				$qry = "
            SELECT * from 
              (SELECT
                (CAST(_typ_.agreementtype_nourut as varchar(2))  +'|'+_typ_.agreementtype_ina) as sp_col
                ,_typ_.agreementtype_nourut as sp_urut
                ,convert(nvarchar(10), _sp_.[schedulepaymentdetil_date], 120) AS sp_date
                ,sum(isnull(_sp_.schedulepaymentdetil_amount,0)) AS sp_amount
                ,_agr_.agreement_startdate
              FROM transaksi_agreementtemp _agr_
                LEFT JOIN transaksi_schedulepaymentdetil _sp_ ON _agr_.agreement_id = _sp_.ref_id              
                LEFT JOIN master_agreementtype _typ_ ON _typ_.agreementtype_id = _sp_.agreementtype_id
              WHERE agreement_id = '{$id}'
                AND _sp_.agreementtype_id in (
                  '2000','2100','4000','20000','35000','7000','7500','7600',
                  '7700','5000','5500','21000','21500','6000','6500','10000','10500')
              GROUP BY _typ_.agreementtype_ina, convert(nvarchar(10), _sp_.[schedulepaymentdetil_date], 120), 
                _typ_.agreementtype_nourut, _agr_.agreement_startdate
            )#sp_table
            order by sp_date
       ";
		}
		else
		{
			$qry = "
            SELECT * from 
              (SELECT
                (CAST(_typ_.agreementtype_nourut as varchar(2))  +'|'+_typ_.agreementtype_ina) as sp_col
                ,_typ_.agreementtype_nourut as sp_urut
                ,convert(nvarchar(10), _sp_.[schedulepaymentdetil_date], 120) AS sp_date
                ,sum(isnull(_sp_.schedulepaymentdetil_amount,0)) AS sp_amount
                ,_agr_.agreement_startdate
              FROM transaksi_agreement _agr_
                LEFT JOIN transaksi_schedulepaymentdetil _sp_ ON _agr_.agreement_id = _sp_.ref_id              
                LEFT JOIN master_agreementtype _typ_ ON _typ_.agreementtype_id = _sp_.agreementtype_id
              WHERE agreement_id = '{$id}'
                AND _sp_.agreementtype_id in (
                  '2000','2100','4000','20000','35000','7000','7500','7600',
                  '7700','5000','5500','21000','21500','6000','6500','10000','10500')
              GROUP BY _typ_.agreementtype_ina, convert(nvarchar(10), _sp_.[schedulepaymentdetil_date], 120), 
                _typ_.agreementtype_nourut, _agr_.agreement_startdate
            )#sp_table
            order by sp_date
       ";
		}
		return $this->db->query($qry)->result();
		
	   }

   }
   
   function getangsuran($id){
		 $agr_id = substr($id, 0,2); 
		if($agr_id == 'AT')
		{
			$sql="SELECT
			  SUM(_det_.agreementdetil_installmentpayment) as angsuran
			FROM transaksi_agreementtemp _agr_  
			  INNER JOIN transaksi_agreementtempdetil _det_ on _agr_.agreement_id=_det_.agreement_id
			  LEFT JOIN master_unit _unit_ on _unit_.branch_id = _agr_.branch_id and _unit_.unit_id=_det_.agreementdetil_unit
			WHERE _agr_.agreement_id='$id'
			  AND (_det_.agreementtype_id='4000' OR _det_.agreementtype_id='20000')
			GROUP BY agreementdetil_unit, agreementdetil_space";
		}
		else
		{
			$sql="SELECT
          SUM(_det_.agreementdetil_installmentpayment) as angsuran
        FROM transaksi_agreement _agr_  
          INNER JOIN transaksi_agreementdetil _det_ on _agr_.agreement_id=_det_.agreement_id
          LEFT JOIN master_unit _unit_ on _unit_.branch_id = _agr_.branch_id and _unit_.unit_id=_det_.agreementdetil_unit
        WHERE _agr_.agreement_id='$id'
          AND (_det_.agreementtype_id='4000' OR _det_.agreementtype_id='20000')
        GROUP BY agreementdetil_unit, agreementdetil_space";
		}
   
  return $this->db->query($sql)->result_array(); 
 }
    
   function getunitloo($id){
	   $agr_id = substr($id, 0,2); 
	  if($agr_id == 'AT')
		{
			$sql="select distinct 
	a.agreementdetil_unit as unit_name,a.agreementdetil_space as unit_sqm, 
	'-' as lantai_name 
	from dbo.transaksi_agreementtempdetil a 
	inner join transaksi_agreementtemp b on a.agreement_id=b.agreement_id	
        where a.agreement_id='$id' and (a.agreementtype_id='4000' or a.agreementtype_id='20000')";
		}
		else
		{
			$sql="select distinct 
a.agreementdetil_unit as unit_name,a.agreementdetil_space as unit_sqm, 
'-' as lantai_name 
from dbo.transaksi_agreementtempdetil a 
inner join transaksi_agreementtemp b on a.agreement_id=b.agreement_id	
        where a.agreement_id='$id' and (a.agreementtype_id='4000' or a.agreementtype_id='20000')"; 
		}
   
     return $this->db->query($sql)->result(); 
	}
	 
   function get_header($id){   

     if (isset($id)){
		$agr_id = substr($id, 0,2); 
		if($agr_id == 'AT')
		{
			$qry="select 
              distinct agreement_id, rekanan_name, agreement_startdate, 
              _bra_.branch_namerpt as branch_name, _bran_.rekananshipping_name, 
              _agr_.agreement_loonumber,
              _agr_.agreement_startdate,
              _agr_.agreement_enddate,
              _agr_.agreement_term, _agr_.agreement_virtualaccount,_agr_.agreement_lanumber
            from transaksi_agreementtemp _agr_         
              JOIN master_branch as _bra_ on _bra_.branch_id=_agr_.branch_id
              JOIN master_rekanan AS _rek_ ON _rek_.rekanan_id = _agr_.rekanan_id
              JOIN master_rekananshipping AS _bran_ ON _bran_.rekanan_id = _agr_.rekanan_id AND _agr_.rekananshipping_line = _bran_.rekananshipping_line
              LEFT JOIN master_rekanancontact as c on c.rekanan_id=_agr_.rekanan_id
            where agreement_id = '$id'";
		}	
		else
		{
			$qry="select 
              distinct agreement_id, rekanan_name, agreement_startdate, 
              _bra_.branch_namerpt as branch_name, _bran_.rekananshipping_name, 
              _agr_.agreement_loonumber,
              _agr_.agreement_startdate,
              _agr_.agreement_enddate,
              _agr_.agreement_term, _agr_.agreement_virtualaccount,_agr_.agreement_lanumber
            from transaksi_agreement _agr_         
              JOIN master_branch as _bra_ on _bra_.branch_id=_agr_.branch_id
              JOIN master_rekanan AS _rek_ ON _rek_.rekanan_id = _agr_.rekanan_id
              JOIN master_rekananshipping AS _bran_ ON _bran_.rekanan_id = _agr_.rekanan_id AND _agr_.rekananshipping_line = _bran_.rekananshipping_line
              LEFT JOIN master_rekanancontact as c on c.rekanan_id=_agr_.rekanan_id
            where agreement_id = '$id'";
		}	
        return $this->db->query($qry)->result();        
   }
  }
  
   function get_ruang($id){

    if (isset($id)){
		$agr_id = substr($id, 0,2); 
		if($agr_id == 'AT')
		{
			$qry="
        SELECT 'Ruang Sewa' as Ruang, AGD.agreementdetil_unit 
        FROM transaksi_agreementtempdetil AGD
          JOIN transaksi_agreementtemp AG ON AG.agreement_id = AGD.agreement_id
        WHERE AGD.agreementtype_id ='4000' and AG.agreement_id = '{$id}' and ISNULL(AGD.agreementdetil_unit,'') <> ''
        GROUP BY AGD.agreementdetil_unit          
      ";
		}
		else
		{
			$qry="
        SELECT 'Ruang Sewa' as Ruang, AGD.agreementdetil_unit 
        FROM transaksi_agreementdetil AGD
          JOIN transaksi_agreement AG ON AG.agreement_id = AGD.agreement_id
        WHERE AGD.agreementtype_id ='4000' and AG.agreement_id = '{$id}' and ISNULL(AGD.agreementdetil_unit,'') <> ''
        GROUP BY AGD.agreementdetil_unit          
      ";
		}
      return $this->db->query($qry)->result();
    }
  }

   function gethargasewa($id){
		  $agr_id = substr($id, 0,2); 
		if($agr_id == 'AT')
		{
			 $sql="
			SELECT 'Uang Sewa per Bulan' as Sewa, AGD.agreementdetil_unit, AGD.agreementdetil_space, 
			  AGD.agreementdetil_unitspot, AGD.agreementdetil_baserent         
			FROM transaksi_agreementtempdetil AGD 
			  JOIN transaksi_agreementtemp AG ON AG.agreement_id = AGD.agreement_id       
			WHERE AGD.agreementtype_id ='4000' AND AG.agreement_id = '$id' AND ISNULL(AGD.agreementdetil_unit,'') <> ''
			GROUP BY AGD.agreementdetil_unit, AGD.agreementdetil_space, AGD.agreementdetil_unitspot, AGD.agreementdetil_baserent
			"; 
		}
		else
		{
			 $sql="
			SELECT 'Uang Sewa per Bulan' as Sewa, AGD.agreementdetil_unit, AGD.agreementdetil_space, 
			  AGD.agreementdetil_unitspot, AGD.agreementdetil_baserent         
			FROM transaksi_agreementdetil AGD 
			  JOIN transaksi_agreement AG ON AG.agreement_id = AGD.agreement_id       
			WHERE AGD.agreementtype_id ='4000' AND AG.agreement_id = '$id' AND ISNULL(AGD.agreementdetil_unit,'') <> ''
			GROUP BY AGD.agreementdetil_unit, AGD.agreementdetil_space, AGD.agreementdetil_unitspot, AGD.agreementdetil_baserent
			"; 
		}
	 
		return $this->db->query($sql)->result(); 
	 }

   function getservicecharge($id){
		 $agr_id = substr($id, 0,2); 
		if($agr_id == 'AT')
		{
			 $sql="SELECT
			  _det_.agreementdetil_baserent, 
			  convert(varchar(10),_det_.agreementdetil_startdate,120) AS sdate,
			  convert(varchar(10),_det_.agreementdetil_enddate,120) AS edate
			FROM transaksi_agreementtemp _agr_  
			  INNER JOIN transaksi_agreementtempdetil _det_ on _agr_.agreement_id=_det_.agreement_id
			  LEFT JOIN master_unit _unit_ on _unit_.branch_id = _agr_.branch_id and _unit_.unit_id=_det_.agreementdetil_unit
			WHERE _agr_.agreement_id='$id'
			  AND (_det_.agreementtype_id in ('5000','5500','21000','21500'))"; 
		}
		else
		{
			 $sql="SELECT
			  _det_.agreementdetil_baserent, 
			  convert(varchar(10),_det_.agreementdetil_startdate,120) AS sdate,
			  convert(varchar(10),_det_.agreementdetil_enddate,120) AS edate
			FROM transaksi_agreement _agr_  
			  INNER JOIN transaksi_agreementdetil _det_ on _agr_.agreement_id=_det_.agreement_id
			  LEFT JOIN master_unit _unit_ on _unit_.branch_id = _agr_.branch_id and _unit_.unit_id=_det_.agreementdetil_unit
			WHERE _agr_.agreement_id='$id'
			  AND (_det_.agreementtype_id in ('5000','5500','21000','21500'))"; 
		}
	 
	  return $this->db->query($sql)->result(); 
	 }
	 
   function gettotallease($id){
		  $agr_id = substr($id, 0,2); 
		if($agr_id == 'AT')
		{
			$sql="SELECT
			  agreement_tlv as total_lease
			FROM transaksi_agreementtemp         
			WHERE agreement_id='$id'         
		  "; 
		}
		else
		{
			$sql="SELECT
			  agreement_tlv as total_lease
			FROM transaksi_agreement          
			WHERE agreement_id='$id'         
		  "; 
		}
	  
	  return $this->db->query($sql)->result(); 
	 } 
 
   function gethargapromo($id){
		 $agr_id = substr($id, 0,2); 
		if($agr_id == 'AT')
		{
			$sql="select  
			  _det_.agreementdetil_baserent
			from transaksi_agreementtemp _agr_  
			  inner join transaksi_agreementtempdetil _det_ on _agr_.agreement_id=_det_.agreement_id
			  left join master_unit _unit_ on _unit_.branch_id = _agr_.branch_id and _unit_.unit_id=_det_.agreementdetil_unit
			where _agr_.agreement_id='$id' 
			  and (_det_.agreementtype_id='6000' or _det_.agreementtype_id='9000')";
		}
		else
		{
			$sql="select  
			  _det_.agreementdetil_baserent
			from transaksi_agreement _agr_  
			  inner join transaksi_agreementdetil _det_ on _agr_.agreement_id=_det_.agreement_id
			  left join master_unit _unit_ on _unit_.branch_id = _agr_.branch_id and _unit_.unit_id=_det_.agreementdetil_unit
			where _agr_.agreement_id='$id' 
			  and (_det_.agreementtype_id='6000' or _det_.agreementtype_id='9000')"; 
		}
	
	return $this->db->query($sql)->result(); 
	}
	
   function gethargafoodcourt($id){
		 $agr_id = substr($id, 0,2); 
		if($agr_id == 'AT')
		{
			$sql="select  
			  _det_.agreementdetil_baserent, _det_.agreementdetil_mia
			from transaksi_agreementtemp _agr_  
			  inner join transaksi_agreementtempdetil _det_ on _agr_.agreement_id=_det_.agreement_id
			  left join master_unit _unit_ on _unit_.branch_id = _agr_.branch_id and _unit_.unit_id=_det_.agreementdetil_unit
			where _agr_.agreement_id='$id' 
			  and (_det_.agreementtype_id='10000')";
		}
		else
		{
			$sql="select  
			  _det_.agreementdetil_baserent, _det_.agreementdetil_mia
			from transaksi_agreement _agr_  
			  inner join transaksi_agreementdetil _det_ on _agr_.agreement_id=_det_.agreement_id
			  left join master_unit _unit_ on _unit_.branch_id = _agr_.branch_id and _unit_.unit_id=_det_.agreementdetil_unit
			where _agr_.agreement_id='$id' 
			  and (_det_.agreementtype_id='10000')";
		}
	 
	return $this->db->query($sql)->result(); 
	}
	
   function getdepe($id){
		$agr_id = substr($id, 0,2); 
		if($agr_id == 'AT')
		{
			$sql="SELECT DISTINCT
			_typ_.agreementtype_ina  
			,_det_.agreementdetil_startdate
			,_det_.agreementdetil_percent
			FROM transaksi_agreementtemp _agr_  
			INNER JOIN transaksi_agreementtempdetil _det_ on _agr_.agreement_id=_det_.agreement_id
			LEFT JOIN master_agreementtype _typ_ on _typ_.agreementtype_id = _det_.agreementtype_id 
			LEFT JOIN master_unit _unit_ on _unit_.branch_id = _agr_.branch_id and _unit_.unit_id=_det_.agreementdetil_unit
			WHERE _agr_.agreement_id='$id'
			AND (_det_.agreementtype_id='2000' or _det_.agreementtype_id='1000')"; 
		}
		else
		{
			$sql="SELECT DISTINCT
			_typ_.agreementtype_ina  
			,_det_.agreementdetil_startdate
			,_det_.agreementdetil_percent
			FROM transaksi_agreement _agr_  
			INNER JOIN transaksi_agreementdetil _det_ on _agr_.agreement_id=_det_.agreement_id
			LEFT JOIN master_agreementtype _typ_ on _typ_.agreementtype_id = _det_.agreementtype_id 
			LEFT JOIN master_unit _unit_ on _unit_.branch_id = _agr_.branch_id and _unit_.unit_id=_det_.agreementdetil_unit
			WHERE _agr_.agreement_id='$id'
			AND (_det_.agreementtype_id='2000' or _det_.agreementtype_id='1000')"; 
		}
	
	return $this->db->query($sql)->result(); 
	}
	 
   function getdeposit($id){
	  $agr_id = substr($id, 0,2); 
		if($agr_id == 'AT')
		{
			$sql="select
			_typ_.agreementtype_ina,
			_det_.agreementdeposit_duedate, 
			sum(_det_.agreementdeposit_idrsubtotal) as agreementdeposit_idrsubtotal
			from transaksi_agreementtemp _agr_  
			inner join transaksi_agreementdeposit _det_ on _agr_.agreement_id=_det_.agreement_id
			left join master_agreementtype _typ_ on _typ_.agreementtype_id = _det_.agreementtype_id 
			left join master_unit _unit_ on _unit_.branch_id = _agr_.branch_id and _unit_.unit_id=_det_.agreementdeposit_unit
			where _agr_.agreement_id='$id'
			and (_det_.agreementtype_id='7000' or _det_.agreementtype_id='7500')
			group by _typ_.agreementtype_ina, _det_.agreementdeposit_duedate"; 	 
		}
		else
		{
			$sql="select
			  _typ_.agreementtype_ina,
			  _det_.agreementdeposit_duedate, 
			  sum(_det_.agreementdeposit_idrsubtotal) as agreementdeposit_idrsubtotal
			from transaksi_agreement _agr_  
			  inner join transaksi_agreementdeposit _det_ on _agr_.agreement_id=_det_.agreement_id
			  left join master_agreementtype _typ_ on _typ_.agreementtype_id = _det_.agreementtype_id 
			  left join master_unit _unit_ on _unit_.branch_id = _agr_.branch_id and _unit_.unit_id=_det_.agreementdeposit_unit
			where _agr_.agreement_id='$id'
			  and (_det_.agreementtype_id='7000' or _det_.agreementtype_id='7500')
			group by _typ_.agreementtype_ina, _det_.agreementdeposit_duedate"; 	
		}
  
  return $this->db->query($sql)->result(); 
 }
  
   function gettdep($id){
	  $agr_id = substr($id, 0,2); 
		if($agr_id == 'AT')
		{
			$sql="select
          _typ_.agreementtype_name,  
          _det_.agreementdeposit_idrsubtotal
        from transaksi_agreement _agr_  
          inner join transaksi_agreementdeposit _det_ on _agr_.agreement_id=_det_.agreement_id
          left join master_agreementtype _typ_ on _typ_.agreementtype_id = _det_.agreementtype_id 
          left join master_unit _unit_ on _unit_.branch_id = _agr_.branch_id and _unit_.unit_id=_det_.agreementdeposit_unit
        where _agr_.agreement_id='$id'
          and (_det_.agreementtype_id='8000')"; 
		}
		else
		{
			$sql="select
          _typ_.agreementtype_name,  
          _det_.agreementdeposit_idrsubtotal
        from transaksi_agreement _agr_  
          inner join transaksi_agreementdeposit _det_ on _agr_.agreement_id=_det_.agreement_id
          left join master_agreementtype _typ_ on _typ_.agreementtype_id = _det_.agreementtype_id 
          left join master_unit _unit_ on _unit_.branch_id = _agr_.branch_id and _unit_.unit_id=_det_.agreementdeposit_unit
        where _agr_.agreement_id='$id'
          and (_det_.agreementtype_id='8000')"; 
		}
  
  return $this->db->query($sql)->result(); 
 }

   function get_branch_list(){ 
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