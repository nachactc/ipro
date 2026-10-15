<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_schedule_payment extends CI_Model{
    
  function __construct()
  {
      parent::__construct();
      check_user_login();
  }
    
	function m_actsave($data, $mode = '')
  {
		
		$vusername = $this->session->userdata('user_fullname');
		$dateNow = date('Y-m-d');
		$data['loo_id'] = $this->input->post('loo_id'); 
		$data['agreement_id'] = $this->input->post('agreement_id');
		$data['no_la']=$this->input->post('no_la'); 
		$data['file_desc'] = trim($this->input->post('file_desc'));
		
	
		//echo var_dump($data);exit; 
		if ($mode == 'add') {

			$data['createby'] = $vusername;
			$data['createdate'] = $dateNow ;
			$this->db->insert('transaksi_la_file', $data);
		} else {

			$data['modifyby'] = $vusername;
			$data['modifydate'] = $dateNow;
			$this->db->where('id_file',$this->input->post('id_file'));
			
			$this->db->update('transaksi_la_file', $data);
		}
		 
	}
	
	function del_files($loo_id)
	{ 
		$data['file_name'] = '';
		$data['file_type'] = '';
		$data['file_size'] = '';
		$this->db->where('id_file',$loo_id);
		return $this->db->update('transaksi_la_file', $data);
	}
	
	function loadfile($loo)
	{
		$query = $this->db->query("select file_name,file_type,file_size from transaksi_la_file where id_file = '$loo'");	
		 
		return $query->row();
	}
	
	function m_actedit()
  {

		$vusername = $this->session->userdata('username');
		$loo_id = $this->input->post('loo_id');
		$loi_no = $this->input->post('loi_id');
		
		$loi_processdate = $this->input->post('loo_procesdate');
		$loi_isprocess = $this->input->post('ckproses');

		if ($loi_isprocess == '1') {

			$loi_processby = $vusername;
		} else {

			$loi_processby = "";
		}

		$loi_sentdate = $this->input->post('loo_sentdate');
		$loi_issent = $this->input->post('cksent');

		if ($loi_issent == '1') {

		  $loi_sentby = $vusername;
		} else {

		  $loi_sentby = "";
		}
		
		
		$loi_receivedate = $this->input->post('loo_recivedate');
		$loi_isreceived = $this->input->post('ckreceive');

		if ($loi_isreceived == '1') {

		  $loi_receivedby=$vusername;
		} else {

			$loi_receivedby="";
		}
		
		$loi_signeddate = $this->input->post('loo_signeddate');
		$loi_issigned = $this->input->post('cksigned');
		
		if ($loi_issigned == '1') {

		  $loi_signedby = $vusername;
		} else {

			$loi_signedby = "";
		}

		$this->db->query("
      update transaksi_loireceived 
      set 					
        loi_no='$loi_no',loi_processby='$loi_processby',loi_processdate='$loi_processdate',
        loi_isprocess='$loi_isprocess',loi_sentby='$loi_sentby',loi_sentdate='$loi_sentdate',
        loi_issent='$loi_issent',loi_receivedby='$loi_receivedby',
        loi_receivedate='$loi_receivedate',loi_isreceived='$loi_isreceived',loi_signedby='$loi_signedby',
        loi_signeddate='$loi_signeddate',loi_issigned='$loi_issigned'
      where 
        loo_id='$loo_id'
    ");

		if ($loi_isprocess == '1') {
			
			$sp_act = "EXEC lm03_TrnAgreement_activeinvoice '$loo_id' ";
      $this->db->query($sp_act);		
		}
	}
	
	
	public function get_data_dialog_loo($search='')
	{

		$where = '';
		if($search != '')
		{ 
			$where = " AND (a.loo_id LIKE '%$search%' OR d.branch_name LIKE '%$search%' OR e.rekanan_name LIKE '%$search%' OR f.rekananshipping_name LIKE '%$search%' )";	
		}
		
		$query = $this->db->query("
        SELECT 
          distinct a.loo_id,c.region_nameshort,d.branch_name,e.rekanan_name,f.rekananshipping_name,g.agreement_id
        FROM 
          transaksi_loo a 
          INNER JOIN master_rekanan e on a.rekanan_id = e.rekanan_id
          LEFT JOIN master_rekananshipping f on a.rekanan_id  = f.rekanan_id and a.rekananshipping_line = f.rekananshipping_line
          LEFT JOIN master_region c on a.region_id = c.region_id
          LEFT JOIN master_branch d on a.branch_id = d.branch_id
          INNER JOIN transaksi_agreement g on a.loo_id = g.agreement_loonumber
        WHERE 
          a.loo_id NOT IN (SELECT loo_id FROM transaksi_loireceived) 
          AND agreement_isclosed = 0	 
        $where
    ");  
	
		//echo $this->db->last_query();
    $result =$query->result_array();

    if ($result ) {
      return $result;
    } else {
      return array();
    }
	}
	
	public function get_data_dialog_loo_rows($search='')
	{

		$where = '';
		if($search != '')
		{
			$search = strip_tags($search);
			$where = " AND (d.branch_name LIKE '%$search%' OR e.rekanan_name LIKE '%$search%' OR f.rekananshipping_name LIKE '%$search%' )";	
		}
		
		$query = $this->db->query("
        SELECT 
          COUNT(a.loo_id) AS jml 
        FROM 
          transaksi_loo a 
          INNER JOIN master_rekanan e on a.rekanan_id = e.rekanan_id
          LEFT JOIN master_rekananshipping f on a.rekanan_id  = f.rekanan_id and a.rekananshipping_line = f.rekananshipping_line
          LEFT JOIN master_region c on a.region_id = c.region_id
          LEFT JOIN master_branch d on a.branch_id = d.branch_id
          INNER JOIN transaksi_agreement g on a.loo_id = g.agreement_loonumber
        WHERE 
          a.loo_id NOT IN (SELECT loo_id FROM transaksi_loireceived)
          AND agreement_isclosed = 0
		      $where
    ");  
		 
    $result = $query->row_array();
    $vresult = $result['jml'];

    if ($result ) {
      return $vresult ;
    } else {
      return array();
    }
		
	}
	
	
  function qry_alldatadialog($limit,$top,$sWhere)
  {
		
    $sWhere = empty($sWhere) ? " WHERE unit_state <> 3 " : $sWhere." AND unit_state <> 3"; 
      
    $qry=" WITH CTE AS (
      select 
        top $limit *,ROW_NUMBER() OVER (ORDER BY unit_id asc) as RowNumber 
      from master_unit $sWhere
      )
      SELECT 
        CTE.*, FLOOR.lantai_name
      FROM 
        CTE 
        JOIN master_lantai AS FLOOR ON CTE.lantai_id = FLOOR.lantai_id
      WHERE 
        RowNumber > $top"; 

	  return $this->db->query($qry)->result_array();		   
  }
   
  function qry_filtereddialog($sWhere)
  {
    $sWhere = empty($sWhere) ? " WHERE unit_state <> 3 " : $sWhere." AND unit_state <> 3";    
    
    $qry="select count(unit_id) as jml from master_unit $sWhere";
    return $this->db->query($qry)->row_array();   
  }
   
  function qry_totalalldialog()
  {
    $qry="select count(unit_id) as jml from master_unit where unit_state<>3";
    return $this->db->query($qry)->row_array();    
  }

  function qry_alldatapop($limit,$top,$sWhere)
  {
    $qry="WITH CTE AS (
        select top $limit SHIP.rekanan_id, SHIP.rekananshipping_line, SHIP.rekananshipping_name, REKA.rekanan_name,
          ROW_NUMBER() OVER (ORDER BY REKA.rekanan_name asc) as RowNumber 
        from master_rekananshipping SHIP
          JOIN master_rekanan AS REKA ON REKA.rekanan_id = SHIP.rekanan_id  
        $sWhere )
    SELECT CTE.*
    FROM CTE      
    WHERE RowNumber > $top";
    return $this->db->query($qry)->result_array();    
  }
   
  function qry_filteredpop($sWhere)
  {
    $qry = "select count(SHIP.rekanan_id) as jml
        from master_rekananshipping SHIP
          JOIN master_rekanan AS REKA ON REKA.rekanan_id = SHIP.rekanan_id $sWhere";
    return $this->db->query($qry)->row_array();    
  }
   
  function qry_totalallpop()
  {

    $qry="select count(SHIP.rekanan_id) as jml
        from master_rekananshipping SHIP
          JOIN master_rekanan AS REKA ON REKA.rekanan_id = SHIP.rekanan_id";
    return $this->db->query($qry)->row_array();    
  }

  function qry_alldataschema($limit,$top,$sWhere)
  {
    $qry="WITH CTE AS (
      select top $limit *,ROW_NUMBER() OVER (ORDER BY skl_id asc) as RowNumber 
      from master_skl $sWhere)
    SELECT CTE.*, UTYPE.unittype_name
    FROM CTE 
      JOIN master_unittype AS UTYPE ON CTE.unittype_id = UTYPE.unittype_id
    WHERE RowNumber > $top";
    return $this->db->query($qry)->result_array();    
  }
   
  function qry_filteredschema($sWhere)
  {
    $qry="select count(skl_id) as jml from master_skl $sWhere";
    return $this->db->query($qry)->row_array();    
  }
   
  function qry_totalallschema()
  {
    $qry="select count(skl_id) as jml from master_skl";
    return $this->db->query($qry)->row_array();    
  }

  function qry_alldatatenant($limit, $top, $sWhere, $orderBy, $sWhereUser)
  {
    $qry = " 
        WITH CTE AS (
          select 
            A.rekanan_id as rekanan_id, rekanan_name, B.branch_id
          from 
            master_rekanan as A 
            left join (
              select 
                MAX(rekanan_id) as rekanan_id, 
                MAX(branch_id) as branch_id 
              from 
                master_rekananshipping 
              group by 
                rekanan_id, branch_id 
            ) as B ON A.rekanan_id = B.rekanan_id
            inner join master_userbranch as C on B.branch_id = C.branch_id 
            $sWhere $sWhereUser
        )

        SELECT 
          CTE.*
        FROM 
          CTE
        ORDER BY 
          rekanan_name asc
        OFFSET $top rows 
        FETCH NEXT $limit ROWS ONLY;
    ";


    return $this->db->query($qry)->result_array();
  }

  function qry_filteredtenant($sWhere,$orderBy,$sWhereUser)
  {
    $qry="
      select count(A.rekanan_id) as jml
      from 
        master_rekanan as A 
        left join (select MAX(rekanan_id) as rekanan_id, MAX(branch_id) as branch_id from master_rekananshipping group by rekanan_id, branch_id ) as B
          ON A.rekanan_id = B.rekanan_id
        inner join master_userbranch as C on B.branch_id = C.branch_id 
      $sWhere $sWhereUser";

    return $this->db->query($qry)->row_array();
  }

  function qry_totalalltenant($sWhere,$sWhereUser)
  {
    $qry="select count(A.rekanan_id) as jml
    from master_rekanan as A left join (select MAX(rekanan_id) as rekanan_id, MAX(branch_id) as branch_id from master_rekananshipping group by rekanan_id, branch_id ) as B
      ON A.rekanan_id = B.rekanan_id
    inner join master_userbranch as C on B.branch_id = C.branch_id $sWhereUser
    ";
    return $this->db->query($qry)->row_array();
  }   

  function qry_alldataregion($limit, $top, $sWhere, $orderBy, $sWhereUser)
  { 
      $qry="WITH CTE AS (
          select top $limit A.region_id, region_name,
            ROW_NUMBER() OVER (ORDER BY A.region_id asc) as RowNumber
          from master_region as A inner join master_userregion as B on A.region_id = B.region_id           
          $sWhere $sWhereUser)
      SELECT CTE.*
      FROM CTE
      WHERE RowNumber > $top";
	  // echo $qry;
	  // exit;
     return $this->db->query($qry)->result_array();
  }

  function qry_filteredregion($sWhere, $orderColumns, $sWhereUser)
  {
    $qry="select count(A.region_id) as jml
        from master_region as A inner join master_userregion as B on A.region_id = B.region_id
          $sWhere $sWhereUser";
    return $this->db->query($qry)->row_array();
  }

  function qry_totalallregion($sWhere, $sWhereUser)
  {
    $qry="select count(A.region_id) as jml
        from master_region as A inner join master_userregion as B on A.region_id = B.region_id
          $sWhereUser";
    return $this->db->query($qry)->row_array();
  }

  function qry_alldatabranch($limit, $top, $sWhere, $orderBy, $sWhereUser)
  {
    $qry = " 
        WITH CTE AS (
          select 
            A.branch_id as branch_id
            , branch_name
            , region_id
          from 
            master_branch A
            JOIN master_regionbranch AS B ON A.branch_id = B.branch_id
		        inner join master_userbranch as C on A.branch_id = C.branch_id
          $sWhere $sWhereUser
        )

        SELECT 
          CTE.*
        FROM 
          CTE
        ORDER BY branch_id
        OFFSET $top rows 
        FETCH NEXT $limit ROWS ONLY;
    ";

    return $this->db->query($qry)->result_array();
  }

  function qry_filteredbranch($sWhere, $orderBy, $sWhereUser)
  {
    $qry="select count(A.branch_id) as jml
          from master_branch as A inner join master_regionbranch as B
          on A.branch_id = B.branch_id
      inner join master_userbranch as C on A.branch_id = C.branch_id
          $sWhere $sWhereUser";
    return $this->db->query($qry)->row_array();
  }

  function qry_totalallbranch($sWhere,$sWhereUser)
  {
    $qry="select count(A.branch_id) as jml
    from master_branch as A inner join master_regionbranch as B
    on A.branch_id = B.branch_id
    inner join master_userbranch as C on A.branch_id = C.branch_id $sWhereUser
        ";
    return $this->db->query($qry)->row_array();
  }

  function qry_alldatabrand($limit,$top,$sWhere,$orderBy,$sWhereUser)
  {

    $qry = " 
        WITH CTE AS (
          select 
          rekananshipping_line
          , rekananshipping_name
          , rekanan_id
          from 
            master_rekananshipping as A 
            inner join master_userbranch as B on A.branch_id = B.branch_id 
          $sWhere $sWhereUser
        )

        SELECT CTE.*
        FROM CTE
        ORDER BY rekananshipping_name
        OFFSET $top rows 
        FETCH NEXT $limit ROWS ONLY;
    ";

    return $this->db->query($qry)->result_array();
  }

  function qry_filteredbrand($sWhere,$orderBy,$sWhereUser)
  {
    $qry="select count(rekananshipping_line) as jml
        from master_rekananshipping  as A inner join master_userbranch as B on A.branch_id = B.branch_id 
          $sWhere $sWhereUser";
    return $this->db->query($qry)->row_array();
  }

  function qry_totalallbrand($sWhere,$sWhereUser)
  {
    $qry="select count(rekananshipping_line) as jml
        from master_rekananshipping  as A inner join master_userbranch as B on A.branch_id = B.branch_id 
    $sWhereUser";
    return $this->db->query($qry)->row_array();
  }

  function qry_alldataagrtype($limit,$top,$sWhere)
  {
    $qry="WITH CTE AS (
        select top $limit agreementtype_id, agreementtype_name,
          ROW_NUMBER() OVER (ORDER BY agreementtype_name asc) as RowNumber
        from master_agreementtype
        $sWhere )
    SELECT CTE.*
    FROM CTE
    WHERE RowNumber > $top";
    return $this->db->query($qry)->result_array();
  }

  function qry_filteredagrtype($sWhere)
  {
    $qry="select count(agreementtype_id) as jml
        from master_agreementtype
          $sWhere";
    return $this->db->query($qry)->row_array();
  }

  function qry_totalallagrtype()
  {
    $qry="select count(agreementtype_id) as jml
        from master_agreementtype";
    return $this->db->query($qry)->row_array();
  }
   
  function qry_alldatalist($limit, $top, $sWhere, $orderBy, $sWhereUser)
  {

    $orderBy = $orderBy === '' ? ' order by schedulepayment_id desc ' : $orderBy;
    
    $sql = " 

        WITH CTE_SP AS 
        (
          SELECT 
            rekananshipping = a.rekanan_id + convert(varchar(10), a.rekananshipping_line)
            , schedulepayment_id
            , schedulepayment_descr
            , schedulepayment_isapproved
            , schedulepayment_isclosed
            , schedulepayment_modifyby
            , schedulepayment_modifydate
            , ref_id
            , ref_line
            , schedulepayment_createby
            , schedulepayment_createdate
            , channel_id
            , transaksi_id
            , schedulepayment_contractno 
            , b.branch_name
            , c.region_name
            , d.strukturunit_name
            , e.rekanan_name
            , f.rekananshipping_name 
          FROM 
            transaksi_schedulepayment a 
            LEFT JOIN master_branch b on a.branch_id = b.branch_id 
            LEFT JOIN master_region c on a.region_id = c.region_id 
            LEFT JOIN master_strukturunit d on a.strukturunit_id = d.strukturunit_id 
            LEFT JOIN master_rekanan e on a.rekanan_id = e.rekanan_id 
            LEFT JOIN master_rekananshipping f on a.rekananshipping_line = f.rekananshipping_line and a.rekanan_id = f.rekanan_id 
          $sWhere
        )

        select 
          *
        from 
          CTE_SP
        $orderBy      
        offset $top rows 
        fetch next $limit rows only;
    "; 

    //var_dump($qry);

    return $this->db->query($sql)->result_array();	   
  }
   
  function qry_alldatalistdetil($limit,$top,$sWhere,$orderBy)
  {
      if ($limit == -1) {

        $limits = "";
      } else {

        $limits = "top $limit";
      }
        
      $qry=" 
        
            WITH CTE as (
          SELECT DISTINCT  $limits ROW_NUMBER() OVER (ORDER BY d.schedulepayment_id) as RowNumber
            ,d.channel_id, d.region_id, d.branch_id, d.rekanan_id,d.schedulepayment_createdate,d.schedulepayment_createby,d.schedulepayment_modifydate,d.schedulepayment_modifyby 
          ,d.schedulepayment_descr,b.*,(ISNULL(b.schedulepaymentdetil_tax,0) * schedulepaymentdetil_idr / 100.00) as tax 
          FROM transaksi_schedulepaymentdetil b 
          INNER JOIN transaksi_schedulepayment d on d.schedulepayment_id = b.schedulepayment_id 
          $sWhere 
          $orderBy
        )
        
        SELECT  * FROM (
        select DISTINCT sp.*,c.agreementtype_name, e.branch_name,f.region_name,g.rekanan_name,
        d.jurnaldetil_idr, d.jurnal_id, j.jurnal_bookdate as jurnal_date,h.rekananshipping_name 
        from CTE sp
        left join transaksi_jurnaldetil d on sp.schedulepayment_id+CAST(schedulepaymentdetil_line as varchar(10))=d.ref_id and acc_id ='2400000' and d.ref_line = schedulepaymentdetil_line
        left join transaksi_jurnal j on d.jurnal_id =j.jurnal_id 
        LEFT JOIN master_Agreementtype c On SP.agreementtype_id = c.agreementtype_id 
        LEFT JOIN master_branch e on SP.branch_id = e.branch_id
        LEFT JOIN master_region f on SP.region_id = f.region_id
        LEFT JOIN master_rekanan g on SP.rekanan_id = g.rekanan_id
        LEFT JOIN master_rekananshipping h on d.rekanan_id = h.rekanan_id and h.rekananshipping_line = d.rekananshipping_line 
        where RowNumber > $top
        ) AS V  
	    ";
      // $qry=" 
      // SELECT  * FROM (
        // SELECT DISTINCT $limits ROW_NUMBER() OVER (ORDER BY d.schedulepayment_id) as RowNumber
        // ,c.agreementtype_name, b.*,d.channel_id, d.region_id, d.branch_id, d.rekanan_id, e.branch_name,f.region_name,g.rekanan_name,d.schedulepayment_createdate,d.schedulepayment_createby,d.schedulepayment_modifydate,d.schedulepayment_modifyby , 
      // (ISNULL(b.schedulepaymentdetil_tax,0) * schedulepaymentdetil_idr / 100.00) as tax,
      // (SELECT TOP 1 jurnal_id FROM transaksi_jurnaldetil WHERE LEFT(transaksi_jurnaldetil.jurnal_id,2) = 'OR' AND transaksi_jurnaldetil.ref_id = b.schedulepayment_id+convert(varchar(10),b.schedulepaymentdetil_line) ORDER BY transaksi_jurnaldetil.jurnal_id DESC ) as jurnal_id,
      // (SELECT SUM(jurnaldetil_idr) FROM transaksi_jurnaldetil WHERE LEFT(transaksi_jurnaldetil.jurnal_id,2) = 'OR' AND jurnaldetil_idr > 0 AND transaksi_jurnaldetil.jurnal_id = (SELECT TOP 1 jurnal_id FROM transaksi_jurnaldetil WHERE LEFT(transaksi_jurnaldetil.jurnal_id,2) = 'OR' AND transaksi_jurnaldetil.ref_id = b.schedulepayment_id+convert(varchar(10),b.schedulepaymentdetil_line) ORDER BY transaksi_jurnaldetil.jurnal_id DESC )  ) as jurnaldetil_idr, 
      // (SELECT TOP 1 jurnal_bookdate FROM transaksi_jurnal LEFT JOIN transaksi_jurnaldetil on transaksi_jurnal.jurnal_id = transaksi_jurnaldetil.jurnal_id WHERE LEFT(transaksi_jurnal.jurnal_id,2) = 'OR' AND transaksi_jurnaldetil.ref_id = b.schedulepayment_id+convert(varchar(10),b.schedulepaymentdetil_line) ORDER BY transaksi_jurnal.jurnal_id DESC )  as jurnal_date,h.rekananshipping_name
      // FROM transaksi_schedulepaymentdetil b 
      // LEFT JOIN master_Agreementtype c On b.agreementtype_id = c.agreementtype_id 
      // INNER JOIN transaksi_schedulepayment d on d.schedulepayment_id = b.schedulepayment_id
      // LEFT JOIN master_branch e on d.branch_id = e.branch_id
      // LEFT JOIN master_region f on d.region_id = f.region_id
      // INNER JOIN master_rekanan g on d.rekanan_id = g.rekanan_id
      // INNER JOIN master_rekananshipping h on d.rekanan_id = h.rekanan_id and d.rekananshipping_line = d.rekananshipping_line
        // $sWhere
        // $orderBy
      // ) AS V 
      // where RowNumber > $top"; 
      //echo $qry;
      //exit;
      $hasil = $this->db->query($qry)->result_array();	   
      // echo var_dump($hasil);
      // exit;
      return $hasil;
  }
   
  function qry_alldatalist_2($search)
  {
    // $sWhere = empty($sWhere) ? " WHERE unittype_id = 6 and isdisabled = 0 " : $sWhere." AND isdisabled = 0 and unittype_id = 6 ";
		$search = urldecode($search); 
		//echo "-->".$search;
		 if (trim($search) != '' )
		 {
			 $where =  " WHERE CTE.loo_id like '%$search%' or  d.branch_name like '%$search%'  or e.rekanan_name like '%$search%' or f.rekananshipping_name like '%$search%' ";
		 }
		 else
		 { $where = '';}
	   $qry="
		SELECT CTE.*,ROW_NUMBER() OVER (ORDER BY CTE.loo_id desc) as RowNumber ,a.loo_id,c.region_nameshort,d.branch_name,e.rekanan_name,f.rekananshipping_name
    	FROM transaksi_loireceived as CTE inner join transaksi_loo a on a.loo_id=CTE.loo_id
		INNER JOIN master_rekanan e on a.rekanan_id = e.rekanan_id
		LEFT JOIN master_rekananshipping f on a.rekanan_id  = f.rekanan_id and a.rekananshipping_line = f.rekananshipping_line
		LEFT JOIN master_region c on a.region_id = c.region_id
		LEFT JOIN master_branch d on a.branch_id = d.branch_id
		$where";
	
	
	   return $this->db->query($qry)->result_array();	   
  }
   
  function qry_filteredlist($sWhere, $orderColumns = '', $sWhereUser)
  {

    // $sWhere = empty($sWhere) ? " WHERE isdisabled = 0 and unittype_id = 6" : $sWhere." AND isdisabled = 0 and unittype_id = 6";	 
    $qry="	   		 
      SELECT  
        count(a.schedulepayment_id) as jml
      FROM 
        transaksi_schedulepayment a
        LEFT JOIN master_branch b on a.branch_id = b.branch_id 
        LEFT JOIN master_region c on a.region_id = c.region_id 
        LEFT JOIN master_strukturunit d on a.strukturunit_id = d.strukturunit_id 
        LEFT JOIN master_rekanan e on a.rekanan_id = e.rekanan_id 
        LEFT JOIN master_rekananshipping f on a.rekananshipping_line = f.rekananshipping_line and a.rekanan_id = f.rekanan_id 
        $sWhere
    ";
  
			//echo $qry;
		return $this->db->query($qry)->row_array();	   
  }
   
  function qry_filteredlistdetil($sWhere, $orderColumns = '')
  {
    // $sWhere = empty($sWhere) ? " WHERE isdisabled = 0 and unittype_id = 6" : $sWhere." AND isdisabled = 0 and unittype_id = 6"; 
    $qry="	 
    WITH CTE as (
      SELECT DISTINCT  d.channel_id, d.region_id, d.branch_id, d.rekanan_id,d.schedulepayment_createdate,d.schedulepayment_createby,d.schedulepayment_modifydate,d.schedulepayment_modifyby 
      ,b.*,(ISNULL(b.schedulepaymentdetil_tax,0) * schedulepaymentdetil_idr / 100.00) as tax 
      FROM transaksi_schedulepaymentdetil b 
      INNER JOIN transaksi_schedulepayment d on d.schedulepayment_id = b.schedulepayment_id 
      $sWhere  
    )

    SELECT  count(*) as jml FROM (
      select DISTINCT sp.*,c.agreementtype_name, e.branch_name,f.region_name,g.rekanan_name,
      d.jurnaldetil_idr, d.jurnal_id, j.jurnal_bookdate as jurnal_date,h.rekananshipping_name 
      from CTE sp
      left join transaksi_jurnaldetil d on sp.schedulepayment_id+CAST(schedulepaymentdetil_line as varchar(10))=d.ref_id and acc_id ='2400000'
      left join transaksi_jurnal j on d.jurnal_id =j.jurnal_id 
      LEFT JOIN master_Agreementtype c On SP.agreementtype_id = c.agreementtype_id 
      LEFT JOIN master_branch e on SP.branch_id = e.branch_id
      LEFT JOIN master_region f on SP.region_id = f.region_id
      LEFT JOIN master_rekanan g on SP.rekanan_id = g.rekanan_id
      LEFT JOIN master_rekananshipping h on d.rekanan_id = h.rekanan_id and d.rekananshipping_line = d.rekananshipping_line  
    ) AS V
    ";
  
    //echo $qry;
    return $this->db->query($qry)->row_array(); 
  }
   
  function qry_totalalllist($sWhere = '', $sWhereUser)
  {

    $qry = "
      SELECT 
        COUNT(schedulepayment_id) as jml
      FROM 
        transaksi_schedulepayment
    ";
    return $this->db->query($qry)->row_array(); 
  }
   
  function qry_totalalllistdetil($sWhere)
  {
    $qry="WITH CTE as (
      SELECT DISTINCT  d.channel_id, d.region_id, d.branch_id, d.rekanan_id,d.schedulepayment_createdate,d.schedulepayment_createby,d.schedulepayment_modifydate,d.schedulepayment_modifyby 
      ,b.*,(ISNULL(b.schedulepaymentdetil_tax,0) * schedulepaymentdetil_idr / 100.00) as tax 
      FROM transaksi_schedulepaymentdetil b 
      INNER JOIN transaksi_schedulepayment d on d.schedulepayment_id = b.schedulepayment_id 
      $sWhere  
    )

    SELECT  count(*) as jml FROM (
      select DISTINCT sp.*,c.agreementtype_name, e.branch_name,f.region_name,g.rekanan_name,
      d.jurnaldetil_idr, d.jurnal_id, j.jurnal_bookdate as jurnal_date,h.rekananshipping_name 
      from CTE sp
      left join transaksi_jurnaldetil d on sp.schedulepayment_id+CAST(schedulepaymentdetil_line as varchar(10))=d.ref_id and acc_id ='2400000'
      left join transaksi_jurnal j on d.jurnal_id =j.jurnal_id 
      LEFT JOIN master_Agreementtype c On SP.agreementtype_id = c.agreementtype_id 
      LEFT JOIN master_branch e on SP.branch_id = e.branch_id
      LEFT JOIN master_region f on SP.region_id = f.region_id
      LEFT JOIN master_rekanan g on SP.rekanan_id = g.rekanan_id
      LEFT JOIN master_rekananshipping h on d.rekanan_id = h.rekanan_id and d.rekananshipping_line = d.rekananshipping_line  
    ) AS V ";
      //  echo $qry;
    return $this->db->query($qry)->row_array(); 
  }
   
  function get_branch_dlg($region_id = '')
	{ 
    $this->db->select('r.branch_id, branch_name');
    $this->db->from('master_regionbranch r');
    $this->db->join('master_branch b', 'r.branch_id = b.branch_id');
    if($region_id != '')
    {  
      $this->db->where('r.region_id', $region_id); 
    }
    $query = $this->db->get();

    $result = $query->result();
    $ret ['']= 'Pilih Store :';
    if($result)
    {
        foreach ($result as $key => $row)
        {
            $ret [$row->branch_id] = $row->branch_name;
        }
    }
    
    return $ret; 
  }
  
  function get_schedulePayment_header($criteria)
  {
		$sp = "lm03_TrnSchedulepayment_Select '','$criteria'";
		$result = $this->db->query($sp); 
		if($result->num_rows() > 0)
		{
			return $result->result();
		}
		else
		{
			return 'kosong';
		}
		
  }

  function get_schedulePayment_detil($criteria)
  {
		$sp = "lm03_TrnSchedulepaymentdetil_Select '','$criteria'";
		$result = $this->db->query($sp); 
		if($result->num_rows() > 0)
		{
			return $result->result();
		}
		else
		{
			return 'kosong';
		}
  }

	function get_detil_SOP_Header($schedule_id)
  {
			
		$stored_pocedure = " EXEC lm03_RptSOP_Header_by_ID '$schedule_id' ";
    $result = $this->db->query($stored_pocedure);
    return $result->result();
	}  

	function get_detil_SOP($schedule_id) 
  {
    
	  $stored_pocedure = " EXEC lm03_RptSOP_detil_by_ID '$schedule_id' ";
    $result = $this->db->query($stored_pocedure);
    return $result->result(); 	   
	}

	function get_detil_SOP_nojurnal($schedule_id) 
  {
	  
    $stored_pocedure = " EXEC lm03_RptSOP_detil_by_ID_no_jurnal '$schedule_id' ";
    $result = $this->db->query($stored_pocedure);
    return $result->result(); 	   
	}

}