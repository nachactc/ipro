<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_or extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
	
   function updateor($or_id,$cboperiode,$book_date,$due_date,$cboaccno,$tdesc){
	   $sqla="select acc_name from master_acc where acc_id='$cboaccno'";
	   $res=$this->db->query($sqla)->row_array();
	   $accname=$res['acc_name'];
	   
	  // echo $accname;exit();
	   
	  $sq="update transaksi_jurnal set jurnal_bookdate='$book_date',acc_id='$cboaccno',jurnal_duedate='$due_date',jurnal_descr='$tdesc',periode_id='$cboperiode' where jurnal_id='$or_id'";
	  
	  $this->db->query($sq);
	  
	  $sq="update transaksi_jurnaldetil set acc_id='$cboaccno' where jurnal_id='$or_id' and jurnaldetil_dk='D'";
	  $this->db->query($sq);
	
	}
	
	function saveh(
		$jurnal_id, 
		$jurnal_bookdate, 
		$jurnal_descr, 
		$jurnal_isposted, 
		$jurnal_createby, 
		$jurnal_createdate, 
		$jurnal_modifyby, 
		$jurnal_modifydate, 
		$jurnal_postby, 
		$jurnal_postdate, 
		$jurnal_duedate, 
		$jurnal_faktur, 
		$jurnal_source, 
		$jurnaltype_id, 
		$channel_id, 
		$region_id, 
		$branch_id, 
		$strukturunit_id, 
		$rekanan_id, 
		$sub1_id, 
		$sub2_id, 
		$currency_id, 
		$currency_rate, 
		$periode_id,
		$acc_id,
		$rekananshipping_line		
	)
	{ 
		$spq= "EXEC cp_TrnJurnal_Insert_W_RL '$jurnal_id','$jurnal_bookdate','$jurnal_descr','$jurnal_isposted','$jurnal_createby','$jurnal_createdate','$jurnal_modifyby','$jurnal_modifydate','$jurnal_postby','$jurnal_postdate','$jurnal_duedate','$jurnal_faktur','$jurnal_source','$jurnaltype_id','$channel_id','$region_id','$branch_id','$strukturunit_id','$rekanan_id','$sub1_id','$sub2_id','$currency_id',$currency_rate,'$periode_id','$acc_id',$rekananshipping_line ";
		 // echo $spq;exit;
		return $this->db->query($spq);
	}
	
	function savep(
			$jurnal_id, 
			$jurnaldetil_line, 
			$jurnaldetil_dk, 
			$jurnaldetil_descr, 
			$jurnaldetil_idr, 
			$jurnaldetil_foreign, 
			$jurnaldetil_foreignrate, 
			$ref_id,
			$ref_line,
			$currency_id, 
			$acc_id, 
			$channel_id, 
			$region_id, 
			$branch_id, 
			$strukturunit_id, 
			$rekanan_id, 
			$sub1_id, 
			$sub2_id, 
			$jurnalbilyet_no, 
			$jurnalbilyet_date, 
			$jurnalbilyet_dateeffective, 
			$jurnalbilyet_receiveperson, 
			$jurnalbilyet_bank,
			$jurnalbilyet_pic,
			$paymenttype_id,
			$modifyby,
			$rekananshipping_line)
	{ 
		$tgl=date('Y-m-d'); 
		$acc_id_setting = $this->get_setting_alloc()->acc_id;
		$acc_id_name = $this->get_setting_alloc()->acc_name;
		foreach($jurnaldetil_line as $key => $n){
			
			$X_jurnaldetil_line=$jurnaldetil_line[$key];  
			$X_jurnaldetil_descr=$jurnaldetil_descr[$key]; 
			$X_jurnaldetil_idr=$jurnaldetil_idr[$key];
			$X_jurnaldetil_foreign=$jurnaldetil_foreign[$key]; 
			$X_jurnaldetil_foreignrate= $jurnaldetil_foreignrate[$key]; 
			$X_currency_id= $currency_id[$key];
			$X_acc_id= $acc_id[$key];  
			$X_sub1_id= $sub1_id[$key]; 
			
			$X_jurnalbilyet_no = '';
			if($jurnalbilyet_no != '')
			{
				$X_jurnalbilyet_no= $jurnalbilyet_no[$key];
			}
			
			$X_jurnalbilyet_date = date('Y-m-d');
			if($jurnalbilyet_date != '')
			{
				$X_jurnalbilyet_date= $jurnalbilyet_date[$key];
			}
			 
			$X_jurnalbilyet_dateeffective = date('Y-m-d');
			if($jurnalbilyet_dateeffective != '')
			{
				$X_jurnalbilyet_dateeffective= $jurnalbilyet_dateeffective[$key];
			}
			 
			$X_jurnalbilyet_receiveperson = '';
			if($jurnalbilyet_receiveperson != '')
			{
				$X_jurnalbilyet_receiveperson= $jurnalbilyet_receiveperson[$key];
			}
			 
			$X_jurnalbilyet_bank = '';
			if($jurnalbilyet_bank != '')
			{
				$X_jurnalbilyet_bank= $jurnalbilyet_bank[$key];
			}
			  
			 
			$X_jurnalbilyet_pic = '';
			if($jurnalbilyet_pic != '')
			{
				$X_jurnalbilyet_pic= $jurnalbilyet_pic[$key];
			} 
			
			$X_paymenttype_id= $paymenttype_id[$key];   
			
			$X_jurnaldetil_idr = str_replace(',','',$X_jurnaldetil_idr);
				
			$spq= "EXEC cp_TrnJurnaldetilbilyet_Insert_WRL '$jurnal_id',$X_jurnaldetil_line,'$jurnaldetil_dk','$X_jurnaldetil_descr',$X_jurnaldetil_idr,$X_jurnaldetil_foreign,$X_jurnaldetil_foreignrate,'$ref_id',$ref_line,'$X_currency_id','$acc_id','$channel_id','$region_id','$branch_id','$strukturunit_id','$rekanan_id','$sub1_id','','$X_jurnalbilyet_no','$X_jurnalbilyet_date','$X_jurnalbilyet_dateeffective','$X_jurnalbilyet_receiveperson','$X_jurnalbilyet_bank','$X_jurnalbilyet_pic','$X_paymenttype_id','$modifyby',$rekananshipping_line "; 
			echo $spq;exit;
			$X_jurnaldetil_line_K = $X_jurnaldetil_line + 10;
			$X_jurnaldetil_idr_K = $X_jurnaldetil_idr*-1;
			$spq_k= "EXEC cp_TrnJurnaldetil_Insert_WRL_CA  '$jurnal_id',$X_jurnaldetil_line_K,'K','$acc_id_name',$X_jurnaldetil_idr_K,$X_jurnaldetil_foreign,1.00,'','','IDR','$acc_id_setting','$channel_id','$region_id','$branch_id','$strukturunit_id','$rekanan_id','$sub1_id','0101','$modifyby',$rekananshipping_line";
			
			 $this->db->query($spq);
			 // echo $spq;exit;
			 $this->db->query($spq_k);
		}
		
	}
	 
	private function get_setting_alloc()
	{
		$sql = "select acc_id,acc_name from master_acc
				where acc_id = (SELECT setting_value FROM master_setting WHERE setting_id = 'acc_id_allocation')";
		$hasil =  $this->db->query($sql);
		return $hasil->row();
	}
	
	
	function qry_isidialog(){
		$sq="select * from master_region";
		return $this->db->query($sq)->result();
	}
	
	function qry_getaloc($return = 'row_array'){
		$sq="exec cp_MstAcc_SelectBySource 'B.source_id = ''OR-UnAllocate'' AND B.dk = ''D'' '"; 
		// echo $sq;exit;
		return $this->db->query($sq)->$return(); 
	}
	
	
	function qry_getlistk($orid){
		$criteria=" jurnal_id=''$orid'' and jurnaldetil_dk=''K'' ";
		$spq= "EXEC cp_TrnJurnaldetil_SelectBYWS 'TCP','$criteria'";
		return $this->db->query($spq)->result();
        
	}
	
	function qry_getrefonse($orid){

		$spq= "cp_TrnJurnalReference_Select 'TCP','$orid'";
		return $this->db->query($spq)->result();
        
	}
	
	
	function qry_getlistd($orid){
		$sq="select A.jurnal_id,  
								A.jurnaldetil_line,  
								A.jurnaldetil_dk,  
								A.jurnaldetil_descr,  
								A.jurnaldetil_idr,  
								A.jurnaldetil_foreign,  
								A.jurnaldetil_foreignrate,  
								A.ref_id, 
								A.ref_line, 
								A.currency_id,  
								A.acc_id,  
								A.channel_id,  
								A.region_id,  
								A.branch_id,  
								A.strukturunit_id, 
								A.rekanan_id,  
								A.rekananshipping_line,  
								A.sub1_id,  
								A.sub2_id,  
								B.jurnalbilyet_no,  
								B.jurnalbilyet_date,  
								B.jurnalbilyet_dateeffective,  
								B.jurnalbilyet_receiveperson,  
								B.jurnalbilyet_bank, 
								B.jurnalbilyet_pic, 
								B.paymenttype_id,
								(select acc_name from master_acc where master_acc.acc_id=A.acc_id) as acc_name,
								paymenttype_name = (select paymenttype_name from master_paymenttype where paymenttype_id = B.paymenttype_id)
							FROM transaksi_jurnaldetil A LEFT JOIN transaksi_jurnalbilyet B ON A.jurnal_id=B.jurnal_id AND A.jurnaldetil_line=B.jurnaldetil_line AND A.jurnaldetil_dk = B.jurnaldetil_dk 
							where A.jurnal_id='$orid' and A.jurnaldetil_dk='D'";
		return $this->db->query($sq)->result();
	}
	
	function qry_getmaster($or_id){
		$sq="select j.*,p.periode_name,r.region_name,b.branch_name,u.strukturunit_name,m.rekanan_name FROM transaksi_jurnal j inner join master_periode p on j.periode_id=p.periode_id
							inner join master_region r on r.region_id=j.region_id inner join master_branch b on b.branch_id=j.branch_id
							inner join master_strukturunit u on u.strukturunit_id=j.strukturunit_id inner join master_rekanan m on m.rekanan_id=j.rekanan_id
							inner join master_acc a on a.acc_id=j.acc_id where jurnal_id='$or_id'";
		return $this->db->query($sq)->result();
	}
	
	function get_paymenttype(){
		$sq="SELECT * FROM master_paymenttype";
		return $this->db->query($sq)->result();
	}
	
	function get_currency(){
		$sq="SELECT * FROM master_currency";
		return $this->db->query($sq)->result();
	}
	
	function qry_mstperiod(){
		
		$spq= "EXEC cp_MstPeriode_Select 'periode_isclosed = 0' ";
		return $this->db->query($spq)->result();
        
	}
	
	function get_accpenerimaan(){
		$sq="SELECT 
					acc_id, acc_name, acc_nameshort, acc_descr, acc_isgroup, acc_parent,
					acc_path, acc_isdisabled, acc_ismonetary, acc_createby, acc_createdate, accsubgroup_id, 
					(SELECT count(acc_id) FROM master_acc where source_id = 'OR-ListSA' AND dk = 'D') as rows 
				FROM (
					SELECT *, ROW_NUMBER() OVER(ORDER BY acc_name ASC) AS row FROM
					(
					SELECT 						
						A.acc_id, 
						A.acc_name, 
						A.acc_nameshort, 
						A.acc_descr, 
						A.acc_isgroup, 
						A.acc_parent,
						A.acc_path, 
						A.acc_ismonetary, 
						A.acc_createby, 
						A.acc_createdate,
						A.accsubgroup_id, 
						B.source_id,
						B.dk,
						acc_isdisabled = (case when A.acc_isdisabled=1 then 1 when B.acc_id is null then 1 else 0 end ) 
					FROM master_acc A INNER JOIN master_source_acc B on A.acc_id = B.acc_id and A.acc_isgroup <> 1 
					) TEST where source_id = 'OR-ListSA' AND dk = 'D'
					) S";
		return $this->db->query($sq)->result();
	}
	
	function qry_isidialogstore($regionid){
		$sq="SELECT * FROM  
(SELECT ROW_NUMBER() OVER(ORDER BY branch_code asc) AS row,
A.region_id, A.branch_id, B.branch_name,(Count(*) OVER()) AS rows  
from master_regionbranch as A inner join master_branch as B on A.branch_id = B.branch_id 
where A.regionbranch_isdisabled ='0' and B.branch_isdisabled ='0' and A.region_id='$regionid' ) master_regionbranch 
Order by row";
		return $this->db->query($sq)->result();
	}
	
	function qry_isidialogtradename($regionid,$branchid){
		$username = $this->session->userdata('username');
		$sq="SELECT DISTINCT * 
FROM   (SELECT Row_number() 
                 OVER( 
                   ORDER BY rekanan_name ASC) AS row, 
               ( Count(*) 
                   OVER() )                   AS rows, 
               shipping_id = ( shipping.rekanan_id 
                               + Cast (shipping.rekananshipping_line AS VARCHAR) 
                             ), 
               shipping.rekanan_id, 
               shipping.rekananshipping_line, 
               shipping.rekananshipping_name, 
               rekanan.rekanan_name, 
               agreement.agreement_contractno, 
               REGBRANCH.region_id, 
               shipping.branch_id, 
               BRANCH.branch_name, 
               REGION.region_name 
        FROM   master_rekananshipping AS shipping 
               LEFT JOIN master_rekanan AS rekanan 
                      ON rekanan.rekanan_id = shipping.rekanan_id 
               LEFT JOIN v_tenantco AS agreement 
                      ON shipping.rekanan_id = agreement.rekanan_id 
                         AND shipping.rekananshipping_line = 
                             agreement.rekananshipping_line 
               LEFT JOIN master_branch BRANCH 
                      ON shipping.branch_id = BRANCH.branch_id 
			  LEFT JOIN master_regionbranch REGBRANCH 
					 ON REGBRANCH.branch_id = shipping.branch_id
               LEFT JOIN master_region REGION 
                      ON REGBRANCH.region_id = REGION.region_id 
		where shipping.branch_id IN ( SELECT branch_id FROM master_userbranch WHERE username = '$username') ";
		if ($regionid != '' AND $branchid != ''):
			$sq .= " AND region_id ='$regionid' AND shipping.branch_id='$branchid' ";
		endif;
		$sq .=") as C Order by rekanan_name ASC";
		  // echo $sq;exit;
		return $this->db->query($sq)->result();
	}
	
	function qry_isidialogstruktur()
	{
		$sq="SELECT DISTINCT * FROM (
		SELECT ROW_NUMBER() OVER(ORDER BY strukturunit_id ASC) AS row, (Count(*) OVER()) AS rows,			
			strukturunit_id ,
			strukturunit_name
		FROM master_strukturunit 
		) as C Order by strukturunit_id ASC";
		//echo $sq;
		$hsl = $this->db->query($sq)->result();
		//echo var_dump($hsl);
		return $hsl;
	}
	
	function qry_isiaccount(){
		$sq="SELECT * from master_acc";
		return $this->db->query($sq)->result();
	}
	
	function qry_isigridheader($vbisnisunit,$vstore,$vtrdname,$hshipline,$hdebtor){
		
		if ((strlen($vbisnisunit)>1) and (strlen($vstore)>1) and (strlen($vtrdname)>1) and (strlen($hshipline)>1)){
			$criteria="region_id=''$vbisnisunit'' and rekanan_id = ''$vtrdname'' AND rekananshipping_line = ''$hshipline'' AND branch_id = ''$vstore'' AND schedulepayment_contractno = ''$hdebtor'' ";
		
		}
		
		$spq= "EXEC cp_TrnJurnalORTRP_SelectInvoiceSingle '', '$criteria' ";
		//echo $spq;exit();
		return $this->db->query($spq)->result_array();
        
	}
	
	function qry_alldatadialog($limit,$top,$sWhere){
		
		 $sWhere = empty($sWhere) ? " WHERE unit_state <> 3 " : $sWhere." AND unit_state <> 3"; 
        
	   $qry="WITH CTE AS (
 				select top $limit *,ROW_NUMBER() OVER (ORDER BY unit_id asc) as RowNumber 
				from master_unit $sWhere)
		SELECT CTE.*, FLOOR.lantai_name
    FROM CTE 
      JOIN master_lantai AS FLOOR ON CTE.lantai_id = FLOOR.lantai_id
    WHERE RowNumber > $top";
    //print_r($qry);
	   return $this->db->query($qry)->result_array();	   
   }
   
   function qry_filtereddialog($sWhere){
	   $sWhere = empty($sWhere) ? " WHERE unit_state <> 3 " : $sWhere." AND unit_state <> 3";    
	   
	   $qry="select count(unit_id) as jml from master_unit $sWhere";
		return $this->db->query($qry)->row_array();
	   
   }
   
   function qry_totalalldialog(){
	   $qry="select count(unit_id) as jml from master_unit where unit_state<>3";
		return $this->db->query($qry)->row_array();
	   
   }   

   function qry_alldatapop($limit,$top,$sWhere){
      $qry="WITH CTE AS (
          select top $limit SHIP.rekanan_id, SHIP.rekananshipping_line, SHIP.rekananshipping_name, REKA.rekanan_name, SHIP.rowid AS debtor_no,
            ROW_NUMBER() OVER (ORDER BY REKA.rekanan_name asc) as RowNumber 
          from master_rekananshipping SHIP
            JOIN master_rekanan AS REKA ON REKA.rekanan_id = SHIP.rekanan_id  
          $sWhere )
      SELECT CTE.*
      FROM CTE      
      WHERE RowNumber > $top";
     return $this->db->query($qry)->result_array();    
   }
   
   function qry_filteredpop($sWhere){
     $qry="select count(SHIP.rekanan_id) as jml
          from master_rekananshipping SHIP
            JOIN master_rekanan AS REKA ON REKA.rekanan_id = SHIP.rekanan_id $sWhere";
    return $this->db->query($qry)->row_array();
     
   }
   
   function qry_totalallpop(){
     $qry="select count(SHIP.rekanan_id) as jml
          from master_rekananshipping SHIP
            JOIN master_rekanan AS REKA ON REKA.rekanan_id = SHIP.rekanan_id";
    return $this->db->query($qry)->row_array();
     
   }

   function qry_alldataschema($limit,$top,$sWhere){
     $qry="WITH CTE AS (
        select top $limit *,ROW_NUMBER() OVER (ORDER BY skl_id asc) as RowNumber 
        from master_skl $sWhere)
    SELECT CTE.*, UTYPE.unittype_name
    FROM CTE 
      JOIN master_unittype AS UTYPE ON CTE.unittype_id = UTYPE.unittype_id
    WHERE RowNumber > $top";
     return $this->db->query($qry)->result_array();    
   }
   
   function qry_filteredschema($sWhere){
     $qry="select count(skl_id) as jml from master_skl $sWhere";
    return $this->db->query($qry)->row_array();
     
   }
   
   function qry_totalallschema(){
     $qry="select count(skl_id) as jml from master_skl";
    return $this->db->query($qry)->row_array();
     
   }
   
    function qry_alldatalist($limit,$top,$sWhere){
$username = $this->session->userdata('username');		
$sWhere=str_replace('WHERE','AND',$sWhere);
		 $qry="SELECT * FROM (
SELECT  top  $limit v_jurnal.* ,ROW_NUMBER() OVER (ORDER BY jurnal_bookdate desc) as RowNumber, 
(select region_name from master_region where master_region.region_id=v_jurnal.region_id) as region_name,
(select branch_name from master_branch where master_branch.branch_id=v_jurnal.branch_id) as branch_name,
(select strukturunit_name from master_strukturunit where master_strukturunit.strukturunit_id=v_jurnal.strukturunit_id) as strukturunit_name,
(select rekanan_name from master_rekanan where master_rekanan.rekanan_id=v_jurnal.rekanan_id) as rekanan_name,
'' as rekananshipping_name,
0 as rekananshipping_line
FROM v_jurnal  
where jurnaltype_id='OR' AND ( jurnal_source = 'OR-UnAllocate' ) $sWhere AND v_jurnal.branch_id in (SELECT branch_id FROM master_userbranch WHERE username = '$username') ) as v WHERE RowNumber > $top  ";
// echo $qry;exit;
	    return $this->db->query($qry)->result_array();
   }
   
    function qry_filteredlist($sWhere){
$username = $this->session->userdata('username');			
$sWhere=str_replace('WHERE','AND',$sWhere);
			   $qry="SELECT count(jurnal_id) as jml FROM (
SELECT  * ,ROW_NUMBER() OVER (ORDER BY jurnal_bookdate desc) as RowNumber, 
(select region_name from master_region where master_region.region_id=v_jurnal.region_id) as region_name,
(select branch_name from master_branch where master_branch.branch_id=v_jurnal.branch_id) as branch_name,
(select strukturunit_name from master_strukturunit where master_strukturunit.strukturunit_id=v_jurnal.strukturunit_id) as strukturunit_name,
(select rekanan_name from master_rekanan where master_rekanan.rekanan_id=v_jurnal.rekanan_id) as rekanan_name
FROM v_jurnal ) as v WHERE jurnaltype_id='OR' AND  ( jurnal_source = 'OR-UnAllocate' ) AND branch_id IN (SELECT branch_id FROM master_userbranch WHERE username = '$username') $sWhere ";
			  
		return $this->db->query($qry)->row_array();
	   
   }
   
   function qry_totalalllist($sWhere){
	  $sWhere=str_replace('WHERE','AND',$sWhere);
		   $qry="SELECT count(jurnal_id) as jml FROM (
SELECT  * ,ROW_NUMBER() OVER (ORDER BY jurnal_bookdate desc) as RowNumber, 
(select region_name from master_region where master_region.region_id=v_jurnal.region_id) as region_name,
(select branch_name from master_branch where master_branch.branch_id=v_jurnal.branch_id) as branch_name,
(select strukturunit_name from master_strukturunit where master_strukturunit.strukturunit_id=v_jurnal.strukturunit_id) as strukturunit_name,
(select rekanan_name from master_rekanan where master_rekanan.rekanan_id=v_jurnal.rekanan_id) as rekanan_name
FROM v_jurnal ) as v WHERE jurnaltype_id='OR' AND  ( jurnal_source = 'OR-ListSA' ) $sWhere";
		return $this->db->query($qry)->row_array();
	   
   }
    
  function sholdetilby_id($id){          
        $sql = "
          SELECT LD.*, UNIT.unit_name AS unit_name, AT.agreementtype_name AS agreementtype_name
          FROM transaksi_loodetil LD
            JOIN transaksi_loo LH ON LH.loo_id = LD.loo_id 
            JOIN master_unit UNIT ON UNIT.unit_id = LD.unit_id AND UNIT.region_id = LH.region_id AND UNIT.branch_id = LH.branch_id
            JOIN master_agreementtype AT ON AT.agreementtype_id = LD.agreementtype_id
          WHERE LD.loo_id = '$id'
          ORDER BY  loo_id, loodetil_line ASC";  
    return $this->db->query($sql)->result();      
  }

  function vdetilunitby_id($id){          
        $sql = "
          SELECT LU.*, UNIT.unit_name AS unit_name, LT.lantai_name AS lantai_name
          FROM transaksi_loounit LU 
            JOIN transaksi_loo LH ON LH.loo_id = LU.loo_id
            JOIN master_unit UNIT ON UNIT.unit_id = LU.unit_id AND UNIT.region_id = LH.region_id AND UNIT.branch_id = LH.branch_id
            JOIN master_lantai LT ON LT.lantai_id = LU.lantai_id
          WHERE LU.loo_id = '$id'";  
    return $this->db->query($sql)->result();      
  }
	  
   function dataconf($uid){        

        $sql = " 
          SELECT DISTINCT LOH.*, 
            REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name, 
            UNIT.unit_name, LOD.unit_id
          FROM transaksi_loo LOH
            JOIN transaksi_loounit LOU ON LOU.loo_id = LOH.loo_id
            JOIN transaksi_loodetil LOD ON LOH.loo_id = LOD.loo_id
            JOIN master_region AS REGION ON LOU.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON LOU.branch_id = BRANCH.branch_id
            JOIN master_rekanan AS REKAN ON LOU.rekanan_id = REKAN.rekanan_id
            JOIN master_rekananshipping AS BRAND ON LOU.rekanan_id = BRAND.rekanan_id AND LOU.rekananshipping_line = BRAND.rekananshipping_line
            JOIN master_unit AS UNIT ON UNIT.unit_id = LOD.unit_id AND UNIT.region_id = LOU.region_id AND UNIT.branch_id = LOU.branch_id
          WHERE LOH.isconfirm = '0' AND LOH.isapproved = '1'  AND UNIT.unit_state <> '3' AND LOD.unit_id like '%{$uid}%' 
          ORDER BY loo_id desc ";    

        return $this->db->query($sql)->result_array();
    }

    function dataapp($uid){

        $sql = " 
          SELECT DISTINCT LOH.*, 
            REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name, 
            UNIT.unit_name, LOD.unit_id
          FROM transaksi_loo LOH
            JOIN transaksi_loounit LOU ON LOU.loo_id = LOH.loo_id
            JOIN transaksi_loodetil LOD ON LOH.loo_id = LOD.loo_id
            JOIN master_region AS REGION ON LOU.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON LOU.branch_id = BRANCH.branch_id
            JOIN master_rekanan AS REKAN ON LOU.rekanan_id = REKAN.rekanan_id
            JOIN master_rekananshipping AS BRAND ON LOU.rekanan_id = BRAND.rekanan_id AND LOU.rekananshipping_line = BRAND.rekananshipping_line
            JOIN master_unit AS UNIT ON UNIT.unit_id = LOD.unit_id AND UNIT.region_id = LOU.region_id AND UNIT.branch_id = LOU.branch_id
          WHERE LOH.isapproved = '0' AND UNIT.unit_state <> '2'  AND LOD.unit_id like '%{$uid}%' 
          ORDER BY loo_id desc ";

        return $this->db->query($sql)->result_array();
    }

   function dataapplist($uid){

        $sql = " 
          SELECT DISTINCT LOH.*, 
            REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name,'' as unit_id
          FROM transaksi_loo LOH
            JOIN transaksi_loounit LOU ON LOU.loo_id = LOH.loo_id
            JOIN transaksi_loodetil LOD ON LOH.loo_id = LOD.loo_id
            JOIN master_region AS REGION ON LOU.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON LOU.branch_id = BRANCH.branch_id
            JOIN master_rekanan AS REKAN ON LOU.rekanan_id = REKAN.rekanan_id
            JOIN master_rekananshipping AS BRAND ON LOU.rekanan_id = BRAND.rekanan_id AND LOU.rekananshipping_line = BRAND.rekananshipping_line
            JOIN master_unit AS UNIT ON UNIT.unit_id = LOD.unit_id AND UNIT.region_id = LOU.region_id AND UNIT.branch_id = LOU.branch_id
          WHERE LOH.isapproved = '0' AND UNIT.unit_state <> '2' AND LOH.unittype_id <> 6  
            AND LOD.unit_id like '%{$uid}%' 
          ORDER BY loo_id desc ";

        return $this->db->query($sql)->result_array();
    }
	
   function dataapplistApproved($uid){

        $sql = " 
          SELECT DISTINCT LOH.*, 
            REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name,'' as unit_id
          FROM transaksi_loo LOH
            JOIN transaksi_loounit LOU ON LOU.loo_id = LOH.loo_id
            JOIN transaksi_loodetil LOD ON LOH.loo_id = LOD.loo_id
            JOIN master_region AS REGION ON LOU.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON LOU.branch_id = BRANCH.branch_id
            JOIN master_rekanan AS REKAN ON LOU.rekanan_id = REKAN.rekanan_id
            JOIN master_rekananshipping AS BRAND ON LOU.rekanan_id = BRAND.rekanan_id AND LOU.rekananshipping_line = BRAND.rekananshipping_line
            JOIN master_unit AS UNIT ON UNIT.unit_id = LOD.unit_id AND UNIT.region_id = LOU.region_id AND UNIT.branch_id = LOU.branch_id
          WHERE LOH.isapproved = '1'  
            AND LOD.unit_id like '%{$uid}%' 
          ORDER BY loo_id desc ";

        return $this->db->query($sql)->result_array();
    }
	
    function dataprintconf($uid){

        $sql = " 
          SELECT DISTINCT LOH.*, REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name, UNIT.unit_name, LOD.unit_id 
          FROM transaksi_loo LOH
            JOIN transaksi_loodetil LOD ON LOH.loo_id = LOD.loo_id
            JOIN master_region AS REGION ON LOH.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON LOH.branch_id = BRANCH.branch_id
            JOIN master_rekanan AS REKAN ON LOH.rekanan_id = REKAN.rekanan_id
            JOIN master_rekananshipping AS BRAND ON LOH.rekanan_id = BRAND.rekanan_id AND LOH.rekananshipping_line = BRAND.rekananshipping_line
            JOIN master_unit AS UNIT ON UNIT.unit_id = LOD.unit_id AND UNIT.region_id = LOH.region_id AND UNIT.branch_id = LOH.branch_id
          WHERE LOH.isapproved = '0' AND LOH.isconfirm = '1' AND LOD.unit_id like '%{$uid}%' ";    

        return $this->db->query($sql)->result_array();
    }
    
 function getunitloo($uid){
  $sql="select distinct c.unit_name,c.unit_sqm from dbo.transaksi_loodetil a
     inner join transaksi_loo b on a.loo_id=b.loo_id
     inner join master_unit c on b.branch_id=c.branch_id and c.unit_id=a.unit_id
     where a.loo_id='$uid' and a.agreementtype_id='4000'";  
     return $this->db->query($sql)->result(); 
 }
 
  function gethargasewa($uid){
  $sql="select  a.loodetil_descr+' (' +c.unit_name+' )' as titleharga,a.loodetil_baserent  from dbo.transaksi_loodetil a
     inner join transaksi_loo b on a.loo_id=b.loo_id
     inner join master_unit c on b.branch_id=c.branch_id and c.unit_id=a.unit_id
     where a.loo_id='$uid' and a.agreementtype_id='4000' order by a.unit_id,a.loodetil_line asc"; 
    return $this->db->query($sql)->result(); 
 }
 
 function getservicecharge($uid){
  $sql="select SUM(loodetil_baserent) as servicecharge from transaksi_loodetil 
  where loo_id='$uid' and agreementtype_id IN ('5000','21500')"; 
  return $this->db->query($sql)->row_array(); 
 }
 
  function getpromolevy($uid){
  $sql="select SUM(loodetil_baserent) as promolevy from transaksi_loodetil 
  where loo_id='$uid' and agreementtype_id='6000'"; 
  return $this->db->query($sql)->row_array(); 
 }
 
  function getdepositr($uid){
  $sql="select loodetil_int as depositr,loodetil_baserent from transaksi_loodetil 
  where loo_id='$uid' and agreementtype_id='7000'"; 
  return $this->db->query($sql)->row_array(); 
 }
 
 function viewconfprint($loo_id){     

     if (isset($loo_id)){
        return $this->db->query("
           select top 1 LOO.loo_id,LOO.conf_id, convert(varchar(10),loo_date,120) AS loo_date, 
              convert(varchar(10),loo_sdate,120) AS loo_sdate, convert(varchar(10),loo_edate,120) AS loo_edate,
              loo_term,
              LOO.branch_id, LOO.rekanan_id, LOO.rekananshipping_line, REKAN.rekanan_name, BRAND.rekananshipping_name,c.rekanancontact_name,
        REKAN.rekanan_telp,REKAN.rekanan_email,branch.branch_name,REKAN.rekanan_address,REKAN.rekanan_city,
        l.lantai_name,u.unit_name,u.unit_sqm,d.loodetil_baserent
        
           from transaksi_loo AS LOO 
       JOIN transaksi_loodetil d on LOO.loo_id=d.loo_id
       JOIN master_branch as branch on branch.branch_id=LOO.branch_id
              JOIN master_rekanan AS REKAN ON LOO.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON LOO.rekanan_id = BRAND.rekanan_id AND LOO.rekananshipping_line = BRAND.rekananshipping_line
        JOIN master_rekanancontact as c on c.rekanan_id=LOO.rekanan_id
        JOIN master_unit u on u.unit_id=d.unit_id
        JOIN master_lantai l on l.lantai_id=u.lantai_id
           where LOO.loo_id='$loo_id'
       ")->result();        
   }

 }

 function getskema($id){

  $qry= " SELECT A.*, B.agreementtype_name
          FROM master_sklterm A inner join master_agreementtype B ON A.skl_atype = B.agreementtype_id
          WHERE A.skl_id = '{$id}' ";

  return $this->db->query($qry)->result_array();   
 }   

 function getPassword($id){

  $qry= " SELECT A.*, B.agreementtype_name
          FROM master_sklterm A inner join master_agreementtype B ON A.skl_atype = B.agreementtype_id
          WHERE A.skl_id = '{$id}' ";

  return $this->db->query($qry)->result_array();   
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
