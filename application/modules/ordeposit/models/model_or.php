<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_or extends CI_Model
{
	
    function __construct()
    {
        parent::__construct();
    }

    function updateor($or_id, $cboperiode, $book_date, $due_date, $cboaccno, $tdesc)
    {
        $sqla = "select acc_name from master_acc where acc_id='$cboaccno'";
        $res = $this
            ->db
            ->query($sqla)->row_array();
        $accname = $res['acc_name'];

        // echo $accname;exit();
        $sq = "update transaksi_jurnal set jurnal_bookdate='$book_date',acc_id='$cboaccno',jurnal_duedate='$due_date',jurnal_descr='$tdesc',periode_id='$cboperiode' where jurnal_id='$or_id'";
		// echo $sq;exit;
        $this
            ->db
            ->query($sq);

        // $sq = "update transaksi_jurnaldetil set acc_id='$cboaccno' where jurnal_id='$or_id' and jurnaldetil_dk='D'";
        // $this
            // ->db
            // ->query($sq);

        // $sqq = "update transaksi_jurnaldetil set jurnaldetil_descr='$accname' where jurnal_id='$or_id' and jurnaldetil_dk='K' and ref_id<>''";
        // $this
            // ->db
            // ->query($sqq);
    }

    function saveh($jurnal_id, $jurnal_bookdate, $jurnal_descr, $jurnal_isposted, $jurnal_createby, $jurnal_createdate, $jurnal_modifyby, $jurnal_modifydate, $jurnal_postby, $jurnal_postdate, $jurnal_duedate, $jurnal_faktur, $jurnal_source, $jurnaltype_id, $channel_id, $region_id, $branch_id, $strukturunit_id, $rekanan_id, $sub1_id, $sub2_id, $currency_id, $currency_rate, $periode_id, $acc_id, $jurnal_tglbuktipotong)
    {

        $tgl = date('Y-m-d');
        $createby = $this
            ->session
            ->userdata('user_fullname');
        $jurnal_tglbuktipotong = ($jurnal_tglbuktipotong == '') ? date('Y-m-d') : $jurnal_tglbuktipotong;
        $spq = "EXEC cp_TrnJurnal_Insert_CN_W '$jurnal_id', 
					'$jurnal_bookdate', 
					'$jurnal_descr', 
					 $jurnal_isposted, 
					'$jurnal_createby', 
					'$jurnal_createdate', 
					'$jurnal_modifyby', 
					'$jurnal_modifydate', 
					'$jurnal_postby', 
					'$jurnal_postdate', 
					'$jurnal_duedate', 
					'$jurnal_faktur', 
					'$jurnal_source', 
					'$jurnaltype_id', 
					'$channel_id', 
					'$region_id', 
					'$branch_id', 
					'$strukturunit_id', 
					'$rekanan_id', 
					'$sub1_id', 
					'$sub2_id', 
					'$currency_id', 
					 $currency_rate, 
					'$periode_id',
					'$acc_id',
					'$jurnal_tglbuktipotong'";
         // echo $spq;exit;
        return $this
            ->db
            ->query($spq);
    }

    function savep($jurnal_id, $jurnaldetil_line, $jurnaldetil_dk, $jurnaldetil_descr, $jurnaldetil_idr, $jurnaldetil_foreign, $jurnaldetil_foreignrate, $ref_id, $ref_line, $currency_id, $acc_id, $channel_id, $region_id, $branch_id, $strukturunit_id, $rekanan_id, $sub1_id, $sub2_id, $jurnalbilyet_no, $jurnalbilyet_date, $jurnalbilyet_dateeffective, $jurnalbilyet_receiveperson, $jurnalbilyet_bank, $jurnalbilyet_pic, $paymenttype_id, $modifyby, $rekananshipping_line)
    {
        $tgl = date('Y-m-d');
        foreach ($jurnaldetil_line as $key => $n)
        {

            $X_jurnaldetil_line = $jurnaldetil_line[$key];
            $X_jurnaldetil_idr = $jurnaldetil_idr[$key];
            $X_jurnaldetil_foreignrate = $jurnaldetil_foreignrate[$key];
            $X_currency_id = $currency_id[$key];
            $X_acc_id = $acc_id[$key];
            $X_sub1_id = $sub1_id[$key];
            $X_sub2_id = $sub2_id[$key];
            $X_jurnaldetil_descr = $jurnaldetil_descr[$key];
            $X_ref_id = $ref_id[$key];
            $X_ref_line = $ref_line[$key];
            $X_jurnaldetil_foreign = $jurnaldetil_foreign[$key];
            $X_rekananshipping_line = $rekananshipping_line[$key];
			//echo var_dump($rekananshipping_line);
             
            if ($X_jurnaldetil_descr != '')
            {
                $X_jurnaldetil_descr = $jurnaldetil_descr[$key];
            }

            
            if ($jurnalbilyet_no != '')
            {
                $X_jurnalbilyet_no = $jurnalbilyet_no[$key];
            }

            
            if ($jurnalbilyet_date != '')
            {
                $X_jurnalbilyet_date = $jurnalbilyet_date[$key];
            }
			else
			{
				$X_jurnalbilyet_date = date('Y-m-d');
			}

            
            if ($jurnalbilyet_dateeffective != '' and $jurnalbilyet_dateeffective[$key] != '')
            {
                $X_jurnalbilyet_dateeffective = $jurnalbilyet_dateeffective[$key];
            }
			else
			{
				$X_jurnalbilyet_dateeffective = date('Y-m-d');
			}

           
            if ($jurnalbilyet_receiveperson != ''  and $jurnalbilyet_receiveperson[$key] != '')
            {
                $X_jurnalbilyet_receiveperson = $jurnalbilyet_receiveperson[$key];
            }
			else
			{
				 $X_jurnalbilyet_receiveperson = '';
			}

           
            if ($jurnalbilyet_bank != '' and $jurnalbilyet_bank[$key] != '' )
            {
                $X_jurnalbilyet_bank = $jurnalbilyet_bank[$key];
            }
			else
			{
				 $X_jurnalbilyet_bank = '';
			} 
           
            if ($jurnalbilyet_pic != ''  and $jurnalbilyet_pic[$key] != '' )
            {
                $X_jurnalbilyet_pic = $jurnalbilyet_pic[$key];
            }
			else
			{
				 $X_jurnalbilyet_pic = '';
			}
            
            if ($X_currency_id != ''  and $currency_id[$key] != '' )
            {
                $X_currency_id = $currency_id[$key];
            }
			else
			{
				$X_currency_id = '';
			}

            $X_paymenttype_id = $paymenttype_id[$key];
			
            $X_jurnaldetil_idr = str_replace(',', '', $X_jurnaldetil_idr);
            $jurnaldetil_idr = str_replace(',', '', $jurnaldetil_idr);
			//echo var_dump($X_jurnaldetil_descr);exit;

            $spq = "EXEC cp_TrnJurnaldetilbilyet_Insert_WRL '$jurnal_id',$X_jurnaldetil_line,'$jurnaldetil_dk','$X_jurnaldetil_descr',$X_jurnaldetil_idr,$X_jurnaldetil_foreign,$X_jurnaldetil_foreignrate,'$X_ref_id',$X_ref_line,'$X_currency_id','$X_acc_id','$channel_id','$region_id','$branch_id','$strukturunit_id','$rekanan_id','$X_sub1_id','$X_sub2_id','$X_jurnalbilyet_no','$X_jurnalbilyet_date','$X_jurnalbilyet_dateeffective','$X_jurnalbilyet_receiveperson','$X_jurnalbilyet_bank','$X_jurnalbilyet_pic','$X_paymenttype_id','$modifyby',$X_rekananshipping_line ";
            
			// echo  var_dump($jurnaldetil_line);
			//echo var_dump($spq);
		 
             $this
                ->db
                ->query($spq);
        }
		

    }

    function saved($jurnal_id, $xtline, $xcbaccpenerimaan, $xtreceive, $xforeign, $xrate, $xrefid, $xref_line, $hbisnisunit, $hstore, $tsruktur_id, $xrekananid, $vtsub1_id, $vtsub2_id, $xaccid, $xrekananship,$channel_id)
    {
        $tgl = date('Y-m-d');
        $modifyby = $this
            ->session
            ->userdata('user_fullname');
        foreach ($xtline as $key => $n)
        {
            $txtline = $xtline[$key];
            $txcbaccpenerimaan = $xcbaccpenerimaan[$key];
            $txtreceive = $xtreceive[$key] * -1;
            $txforeign = $xforeign[$key];
            $txrate = $xrate[$key];
            $txrefid = $xrefid[$key];
            $txref_line = $xref_line[$key];
            $txaccid = $xaccid[$key];
            $txrekananid = $xrekananid[$key];
            $xvtsub2_id = $vtsub2_id[$key];
            $xxrekananship = $xrekananship[$key];
            $xvtsub1_id = $vtsub1_id[$key];
            //echo $txtline;echo "<br>";
            

            $spq = "EXEC cp_TrnJurnaldetil_Insert_WRL_CA  '$jurnal_id',$txtline,'K','$txcbaccpenerimaan',$txtreceive,$txforeign,1.00,'$txrefid','$txref_line','IDR','$txaccid','$channel_id','$hbisnisunit','$hstore','$tsruktur_id','$xrekananid','$xvtsub1_id','$xvtsub2_id','$modifyby',$xxrekananship";

            // echo $spq;exit;
            $this
                ->db
                ->query($spq);
        }

    }

    function qry_isidialog()
    {
        $sq = "select * from master_region";
        return $this
            ->db
            ->query($sq)->result();
    }

    function qry_getaloc()
    {
        $sq = "select b.acc_id,b.acc_name from master_setting a inner join master_acc b on a.setting_value=b.acc_id where a.setting_id='acc_id_allocation_cn_unalloc'";
        return $this
            ->db
            ->query($sq)->row_array();
    }

    function qry_isidialogstruktur()
    {
        $sq = "SELECT DISTINCT * FROM (
		SELECT ROW_NUMBER() OVER(ORDER BY strukturunit_id ASC) AS row, (Count(*) OVER()) AS rows,			
			strukturunit_id ,
			strukturunit_name
		FROM master_strukturunit 
		) as C Order by strukturunit_id ASC";
        //echo $sq;
        $hsl = $this
            ->db
            ->query($sq)->result();
        //echo var_dump($hsl);
        return $hsl;
    }

    function qry_getlistk($orid)
    {
        $criteria = " jurnal_id=''$orid'' and jurnaldetil_dk=''K'' ";
        $spq = "EXEC cp_TrnJurnaldetil_SelectBYWS 'TCP','$criteria'";
        return $this
            ->db
            ->query($spq)->result();

    }

    function qry_getrefonse($orid)
    {

        $spq = "cp_TrnJurnalReference_Select 'TCP','$orid'";
        return $this
            ->db
            ->query($spq)->result();

    }

    function qry_getlistd($orid)
    {
        $sq = "select A.jurnal_id,  
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
        return $this
            ->db
            ->query($sq)->result();
    }

    function qry_getmaster($or_id)
    {
        $sq = "select j.*,p.periode_name,r.region_name,b.branch_name,u.strukturunit_name,m.rekanan_name,z.rowid as contract_no 
		FROM transaksi_jurnal j 
		inner join master_periode p on j.periode_id=p.periode_id
							inner join master_region r on r.region_id=j.region_id 
							inner join master_branch b on b.branch_id=j.branch_id
							inner join master_strukturunit u on u.strukturunit_id=j.strukturunit_id 
							inner join master_rekanan m on m.rekanan_id=j.rekanan_id
							LEFT join master_rekananshipping z on z.rekanan_id = j.rekanan_id AND z.rekananshipping_line = j.rekananshipping_line
							inner join master_acc a on a.acc_id=j.acc_id where jurnal_id='$or_id'";
							
        return $this
            ->db
            ->query($sq)->result(); 
    }

    function get_paymenttype()
    {
        $sq = "SELECT * FROM master_paymenttype";
        return $this
            ->db
            ->query($sq)->result();
    }

    function qry_mstperiod()
    {

        $spq = "EXEC cp_MstPeriode_Select 'periode_isclosed = 0' ";
        return $this
            ->db
            ->query($spq)->result();

    }

    function get_accpenerimaan()
    { 
	//EXEC cp_MstAcc_SelectBySource 'B.source_id = ''CN-WHT'' AND B.dk = ''D'' '
        $sq = " SELECT acc_id,acc_name,acc_nameshort FROM master_acc WHERE acc_name like '%BANK%'  ";
        return $this
            ->db
            ->query($sq)->result();
    } 

    function qry_isidialogstore($regionid)
    {
        $sq = "SELECT * FROM  
(SELECT ROW_NUMBER() OVER(ORDER BY branch_code asc) AS row,
A.region_id, A.branch_id, B.branch_name,(Count(*) OVER()) AS rows  
from master_regionbranch as A inner join master_branch as B on A.branch_id = B.branch_id 
where A.regionbranch_isdisabled ='0' and B.branch_isdisabled ='0' and A.region_id='$regionid' ) master_regionbranch 
Order by row";
        return $this
            ->db
            ->query($sq)->result();
    }

    function qry_isidialogtradename($regionid, $branchid)
    {
        $username = $this
            ->session
            ->userdata('username');
        $sq = "SELECT DISTINCT * 
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
        if ($regionid != '' and $branchid != ''):
            $sq .= " AND REGBRANCH.region_id ='$regionid' AND shipping.branch_id='$branchid' ";
        endif;
        $sq .= ") as C Order by rekanan_name ASC";
         // echo $sq;exit;
        return $this
            ->db
            ->query($sq)->result();
    }

    function qry_isiaccount()
    {
        $sq = "SELECT * from master_acc";
        return $this
            ->db
            ->query($sq)->result();
    }
	/** NEW 2020 02 18 **/
	
	/** get acc_id,acc_name dari master acc berdasarkan akun deposit di master setting **/
	/** return nya object 1 row **/
    function qry_isiaccount_row($acc_id)
    {
        $sq = "SELECT * from master_acc WHERE acc_id = ( SELECT setting_value FROM master_setting where setting_id ='$acc_id') ";
        $hasil = $this
            ->db
            ->query($sq);
		if($hasil->num_rows() > 0 )
		{
			return $hasil->row();
		}
		else
		{
			return 'kosong';
		}
    }
	
	/** get jurnal_id dan jurnaldetil_line dari jurnal invoice berdasarkan akun deposit **/
	/** return nya object 1 row **/
	function qry_getRefInvoice($acc_id,$jurnal_id)
	{
		$sq = "SELECT jurnal_id, jurnaldetil_line FROM transaksi_jurnaldetil WHERE jurnal_id = '$jurnal_id' AND acc_id = '$acc_id' ";
		$hasil = $this
            ->db
            ->query($sq);
		// echo $this->db->last_query();
		if($hasil->num_rows() > 0 )
		{
			return $hasil->row();
		}
		else
		{
			return 'kosong';
		}
	}
	/** END NEW 2020 02 18 **/

    function qry_isigridheader($vbisnisunit, $vstore, $vtrdname, $hshipline, $hdebtor)
    {

        if ((strlen($vbisnisunit) > 1) and (strlen($vstore) > 1) and (strlen($vtrdname) > 1) and (strlen($hshipline) > 1))
        {
            $criteria = "region_id=''$vbisnisunit'' and rekanan_id = ''$vtrdname'' AND rekananshipping_line = ''$hshipline'' AND branch_id = ''$vstore'' ";
            //AND schedulepayment_contractno = ''$hdebtor'' 

        }

        $spq = "EXEC cp_TrnJurnalORTRP_SelectInvoiceSingle_IPRO_Deposit '', '$criteria'";
        // echo $spq;exit();
        return $this
            ->db
            ->query($spq)->result_array();

    }

    function qry_alldatadialog($limit, $top, $sWhere)
    {

        $sWhere = empty($sWhere) ? " WHERE unit_state <> 3 " : $sWhere . " AND unit_state <> 3";

        $qry = "WITH CTE AS (
 				select top $limit *,ROW_NUMBER() OVER (ORDER BY unit_id asc) as RowNumber 
				from master_unit $sWhere)
		SELECT CTE.*, FLOOR.lantai_name
    FROM CTE 
      JOIN master_lantai AS FLOOR ON CTE.lantai_id = FLOOR.lantai_id
    WHERE RowNumber > $top";
        //print_r($qry);
        return $this
            ->db
            ->query($qry)->result_array();
    }

    function qry_filtereddialog($sWhere)
    {
        $sWhere = empty($sWhere) ? " WHERE unit_state <> 3 " : $sWhere . " AND unit_state <> 3";

        $qry = "select count(unit_id) as jml from master_unit $sWhere";
        return $this
            ->db
            ->query($qry)->row_array();

    }

    function qry_totalalldialog()
    {
        $qry = "select count(unit_id) as jml from master_unit where unit_state<>3";
        return $this
            ->db
            ->query($qry)->row_array();

    }

    function qry_alldatapop($limit, $top, $sWhere)
    {
        $qry = "WITH CTE AS (
          select top $limit SHIP.rekanan_id, SHIP.rekananshipping_line, SHIP.rekananshipping_name, REKA.rekanan_name, SHIP.rowid AS debtor_no,
            ROW_NUMBER() OVER (ORDER BY REKA.rekanan_name asc) as RowNumber 
          from master_rekananshipping SHIP
            JOIN master_rekanan AS REKA ON REKA.rekanan_id = SHIP.rekanan_id  
          $sWhere )
      SELECT CTE.*
      FROM CTE      
      WHERE RowNumber > $top";
        return $this
            ->db
            ->query($qry)->result_array();
    }

    function qry_filteredpop($sWhere)
    {
        $qry = "select count(SHIP.rekanan_id) as jml
          from master_rekananshipping SHIP
            JOIN master_rekanan AS REKA ON REKA.rekanan_id = SHIP.rekanan_id $sWhere";
        return $this
            ->db
            ->query($qry)->row_array();

    }

    function qry_totalallpop()
    {
        $qry = "select count(SHIP.rekanan_id) as jml
          from master_rekananshipping SHIP
            JOIN master_rekanan AS REKA ON REKA.rekanan_id = SHIP.rekanan_id";
        return $this
            ->db
            ->query($qry)->row_array();

    }

    function qry_alldataschema($limit, $top, $sWhere)
    {
        $qry = "WITH CTE AS (
        select top $limit *,ROW_NUMBER() OVER (ORDER BY skl_id asc) as RowNumber 
        from master_skl $sWhere)
    SELECT CTE.*, UTYPE.unittype_name
    FROM CTE 
      JOIN master_unittype AS UTYPE ON CTE.unittype_id = UTYPE.unittype_id
    WHERE RowNumber > $top";
        return $this
            ->db
            ->query($qry)->result_array();
    }

    function qry_filteredschema($sWhere)
    {
        $qry = "select count(skl_id) as jml from master_skl $sWhere";
        return $this
            ->db
            ->query($qry)->row_array();

    }

    function qry_totalallschema()
    {
        $qry = "select count(skl_id) as jml from master_skl";
        return $this
            ->db
            ->query($qry)->row_array();

    }

    function qry_alldatalist($limit, $top, $sWhere)
    {
        $username = $this
            ->session
            ->userdata('username');
        $sWhere = str_replace('WHERE', 'AND', $sWhere);
        $qry = "SELECT * FROM (
SELECT distinct top  $limit v_jurnal.* ,ROW_NUMBER() OVER (ORDER BY jurnal_bookdate desc) as RowNumber, 
(select region_name from master_region where master_region.region_id=v_jurnal.region_id) as region_name,
(select branch_name from master_branch where master_branch.branch_id=v_jurnal.branch_id) as branch_name,
(select strukturunit_name from master_strukturunit where master_strukturunit.strukturunit_id=v_jurnal.strukturunit_id) as strukturunit_name,
(select rekanan_name from master_rekanan where master_rekanan.rekanan_id=v_jurnal.rekanan_id) as rekanan_name 
FROM v_jurnal    
where jurnaltype_id='OR' AND ( jurnal_source = 'OR-DEP' ) $sWhere 
AND v_jurnal.branch_id IN (SELECT branch_id FROM master_userbranch WHERE username = '$username')
) as v WHERE RowNumber > $top  ";
        //echo $qry;exit;
        return $this
            ->db
            ->query($qry)->result_array();
    }

    function qry_filteredlist($sWhere)
    {
        $username = $this
            ->session
            ->userdata('username');
        $sWhere = str_replace('WHERE', 'AND', $sWhere);
        $qry = "SELECT count(jurnal_id) as jml FROM (
SELECT  * ,ROW_NUMBER() OVER (ORDER BY jurnal_bookdate desc) as RowNumber, 
(select region_name from master_region where master_region.region_id=v_jurnal.region_id) as region_name,
(select branch_name from master_branch where master_branch.branch_id=v_jurnal.branch_id) as branch_name,
(select strukturunit_name from master_strukturunit where master_strukturunit.strukturunit_id=v_jurnal.strukturunit_id) as strukturunit_name,
(select rekanan_name from master_rekanan where master_rekanan.rekanan_id=v_jurnal.rekanan_id) as rekanan_name
FROM v_jurnal ) as v WHERE jurnaltype_id='CN' AND  ( jurnal_source = 'CN-WHT' ) AND branch_id IN (SELECT branch_id FROM master_userbranch WHERE username = '$username') $sWhere ";
        return $this
            ->db
            ->query($qry)->row_array();

    }

    function qry_totalalllist($sWhere)
    {
        $sWhere = str_replace('WHERE', 'AND', $sWhere);
        $qry = "SELECT count(jurnal_id) as jml FROM (
SELECT  * ,ROW_NUMBER() OVER (ORDER BY jurnal_bookdate desc) as RowNumber, 
(select region_name from master_region where master_region.region_id=v_jurnal.region_id) as region_name,
(select branch_name from master_branch where master_branch.branch_id=v_jurnal.branch_id) as branch_name,
(select strukturunit_name from master_strukturunit where master_strukturunit.strukturunit_id=v_jurnal.strukturunit_id) as strukturunit_name,
(select rekanan_name from master_rekanan where master_rekanan.rekanan_id=v_jurnal.rekanan_id) as rekanan_name
FROM v_jurnal ) as v WHERE jurnaltype_id='OR' AND  ( jurnal_source = 'OR-ListSA' ) $sWhere";
        return $this
            ->db
            ->query($qry)->row_array();

    }

    function insertloo($loo_date, $loo_sdate, $loo_edate, $loo_term, $_createby, $_modifyby, $region, $branch, $lease, $loo_line, $unit_id, $agrtype_id, $loo_baserent, $r_id, $tenant, $brand, $int, $timetype, $loo_descr, $unit_type, $skl_id, $descr, $isper, $percent, $u_line, $u_unit, $u_size, $u_lantai, $d_region, $d_branch, $d_tenant, $d_brand, $u_region, $u_branch, $u_tenant, $u_brand, $product_name, $fitting_out, $grace_period, $size_indoor, $size_outdoor, $debtor_no, $txtpaymentint, $txtleased, $ckguarantor, $txtdemised, $cbotmploo, $loo_comdate, $cbostamp, $txtarpint, $txtarpprosen)
    {

        $datetime1 = date_create($loo_sdate);
        $datetime2 = date_create($loo_edate);
        $datetime2->modify('+1 day');
        $interval = date_diff($datetime1, $datetime2);

        $loo_term = $interval->m + ($interval->y * 12);

        $timestamp = time();

        $loo_id = gen_id_loo($region, 'LOO', 'sequencer_loo', $r_id, $timestamp);

        $virtual_account = get_va($debtor_no);

        $timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);
        $check = $this
            ->db
            ->query("
                 insert into transaksi_loo
                     (loo_id, loo_date, loo_sdate, loo_edate, loo_term, _createby, _createdate,  region_id , branch_id, rekanan_id, rekananshipping_line, loo_type, loo_descr, skl_id, unittype_id, product_name,fitting_out,grace_period,size_indoor,size_outdoor, debtor_no, virtual_acc,payment_installment,leasedyear,guarantor,demised,loo_tempid,loo_comdate,stamp_type,arp_installment,arp_percentage)
                 values
                     ('$loo_id','$loo_date', '$loo_sdate', '$loo_edate', $loo_term,'$_createby','$now','$region','$branch',
                      '$tenant', '$brand', $lease, '$loo_descr','$skl_id', '$unit_type', '$product_name',$fitting_out,$grace_period,$size_indoor,$size_outdoor,
                      '$debtor_no', '$virtual_account','$txtpaymentint','$txtleased','$ckguarantor','$txtdemised','$cbotmploo','$loo_comdate','$cbostamp','$txtarpint','$txtarpprosen')");

        foreach ($loo_line as $key => $n)
        {

            $t_line = $loo_line[$key];
            $t_unit = $unit_id[$key];
            $t_agrtype = $agrtype_id[$key];
            $t_baserent = $loo_baserent[$key];
            $t_baserent = str_replace(',', '', $t_baserent);
            $t_int = $int[$key];
            $t_timet = $timetype[$key];
            $t_descr = $descr[$key];
            $t_isper = ($isper[$key]) ? 1 : 0;
            $t_percent = $percent[$key];
            $t_region = $d_region[$key];
            $t_branch = $d_branch[$key];
            $t_tenant = $d_tenant[$key];
            $t_brand = $d_brand[$key];

            $this
                ->db
                ->query("
             insert into transaksi_loodetil
                 (loo_id, loodetil_line, loodetil_baserent, agreementtype_id, unit_id, loodetil_int, timetype_id, loodetil_descr, loodetil_ispercent, loodetil_percent, region_id, branch_id, rekanan_id, rekananshipping_line,loodetil_sdate,loodetil_edate,loodetil_term)
             values
                 ('$loo_id', $t_line, $t_baserent, '$t_agrtype', '$t_unit', $t_int, '$t_timet', '$t_descr', $t_isper, 
                  $t_percent, '$t_region', '$t_branch','$tenant', '$brand', '$loo_sdate', '$loo_edate', $loo_term )");
        }

        foreach ($u_line as $key => $n)
        {

            $_line = $u_line[$key];
            $_unit = $u_unit[$key];
            $_size = $u_size[$key];
            $_lantai = $u_lantai[$key];
            $_region = $u_region[$key];
            $_branch = $u_branch[$key];
            $_tenant = $u_tenant[$key];
            $_brand = $u_brand[$key];

            $this
                ->db
                ->query("
                insert into transaksi_loounit
                    ( loo_id, loounit_line, loounit_space, unit_id, lantai_id, region_id, branch_id, rekanan_id, rekananshipping_line, loounit_sdate, loounit_edate, loounit_term )
                values
                  ( '$loo_id', $_line, $_size, '$_unit', '$_lantai', '$_region', '$_branch', '$tenant', '$brand', '$loo_sdate', '$loo_edate', $loo_term  )");

            $this
                ->db
                ->query(" UPDATE master_unit SET unit_state = 1 WHERE unit_id='$t_unit' and region_id='$region' and branch_id='$branch' ");
        }

        return $loo_id;

    }

    function sholdetilby_id($id)
    {
        $sql = "
          SELECT LD.*, UNIT.unit_name AS unit_name, AT.agreementtype_name AS agreementtype_name
          FROM transaksi_loodetil LD
            JOIN transaksi_loo LH ON LH.loo_id = LD.loo_id 
            JOIN master_unit UNIT ON UNIT.unit_id = LD.unit_id AND UNIT.region_id = LH.region_id AND UNIT.branch_id = LH.branch_id
            JOIN master_agreementtype AT ON AT.agreementtype_id = LD.agreementtype_id
          WHERE LD.loo_id = '$id'
          ORDER BY  loo_id, loodetil_line ASC";
        return $this
            ->db
            ->query($sql)->result();
    }

    function vdetilunitby_id($id)
    {
        $sql = "
          SELECT LU.*, UNIT.unit_name AS unit_name, LT.lantai_name AS lantai_name
          FROM transaksi_loounit LU 
            JOIN transaksi_loo LH ON LH.loo_id = LU.loo_id
            JOIN master_unit UNIT ON UNIT.unit_id = LU.unit_id AND UNIT.region_id = LH.region_id AND UNIT.branch_id = LH.branch_id
            JOIN master_lantai LT ON LT.lantai_id = LU.lantai_id
          WHERE LU.loo_id = '$id'";
        return $this
            ->db
            ->query($sql)->result();
    }

    function updateloo($loo_id, $loo_date, $loo_descr, $loo_sdate, $loo_edate, $loo_term, $_createby, $_modifyby, $region, $branch, $lease, $loo_line, $unit_id, $agrtype_id, $loo_baserent, $tenant, $brand, $int, $timetype, $descr, $isper, $percent, $u_line, $u_unit, $u_size, $u_lantai, $unit_type, $skl_id, $d_region, $d_branch, $d_tenant, $d_brand, $u_region, $u_branch, $u_tenant, $u_brand, $product_name, $fitting_out, $grace_period, $size_indoor, $size_outdoor, $debtor_no, $txtpaymentint, $txtleased, $ckguarantor, $txtdemised, $cbotmploo, $loo_comdate, $cbostamp, $txtarpint, $txtarpprosen)
    {

        $datetime1 = date_create($loo_sdate);
        $datetime2 = date_create($loo_edate);
        $datetime2->modify('+1 day');

        $interval = date_diff($datetime1, $datetime2);
        $loo_term = $interval->m + ($interval->y * 12);

        $virtual_account = get_va($debtor_no);

        $timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);
        $check = $this
            ->db
            ->query("
            update transaksi_loo
            set loo_date = '$loo_date', loo_descr = '$loo_descr', loo_sdate = '$loo_sdate', loo_edate = '$loo_edate', loo_term = $loo_term,
                _modifyby = '$_modifyby', _modifydate = '$now', region_id = '$region' , branch_id = '$branch',
                rekanan_id = '$tenant', rekananshipping_line = '$brand', 
				        loo_type = $lease, unittype_id = '$unit_type',
				        product_name= '$product_name',fitting_out=$fitting_out,grace_period=$grace_period,size_indoor=$size_indoor,size_outdoor = $size_outdoor,
                debtor_no = '$debtor_no', virtual_acc = '$virtual_account',payment_installment='$txtpaymentint',leasedyear='$txtleased',guarantor='$ckguarantor',demised='$txtdemised'
,loo_tempid='$cbotmploo',loo_comdate='$loo_comdate',stamp_type='$cbostamp',arp_installment='$txtarpint',arp_percentage='$txtarpprosen' where loo_id = '$loo_id'
        ");

        if ($check)
        {
            $this
                ->db
                ->query("delete from transaksi_loodetil where loo_id='$loo_id'");

            foreach ($loo_line as $key => $n)
            {

                $t_line = $loo_line[$key];
                $t_unit = $unit_id[$key];
                $t_agrtype = $agrtype_id[$key];
                $t_baserent = $loo_baserent[$key];
                $t_baserent = str_replace(',', '', $t_baserent);
                $t_int = $int[$key];
                $t_timetype = $timetype[$key];
                $t_descr = $descr[$key];
                $t_isper = ($isper[$key]) ? 1 : 0;
                $t_percent = $percent[$key];
                $t_region = $d_region[$key];
                $t_branch = $d_branch[$key];
                $t_tenant = $d_tenant[$key];
                $t_brand = $d_brand[$key];

                $this
                    ->db
                    ->query("
             insert into transaksi_loodetil
                 (loo_id, loodetil_line, loodetil_baserent, agreementtype_id, unit_id, loodetil_int, timetype_id, loodetil_descr, loodetil_ispercent, loodetil_percent, region_id, branch_id, rekanan_id, rekananshipping_line, loodetil_sdate, loodetil_edate, loodetil_term )
             values
                 ('$loo_id', $t_line, $t_baserent, '$t_agrtype', '$t_unit', $t_int, '$t_timetype', '$t_descr', $t_isper, $t_percent, 
                  '$t_region', '$t_branch', '$tenant', '$brand', '$loo_sdate', '$loo_edate', $loo_term )");
            }

            $this
                ->db
                ->query("delete from transaksi_loounit where loo_id='$loo_id'");

            foreach ($u_line as $key => $n)
            {

                $_line = $u_line[$key];
                $_unit = $u_unit[$key];
                $_size = $u_size[$key];
                $_lantai = $u_lantai[$key];
                $_region = $u_region[$key];
                $_branch = $u_branch[$key];
                $_tenant = $u_tenant[$key];
                $_brand = $u_brand[$key];

                $this
                    ->db
                    ->query("
             insert into transaksi_loounit
                 ( loo_id, loounit_line, loounit_space, unit_id, lantai_id, region_id, branch_id, rekanan_id, rekananshipping_line, 
                  loounit_sdate, loounit_edate, loounit_term )
             values
                 ( '$loo_id', $_line, $_size, '$_unit', '$_lantai', '$_region', '$_branch', '$tenant', '$brand', 
                 '$loo_sdate', '$loo_edate', $loo_term )");
            }

        }
    }

    function deleteloo($loo_id)
    {

        $this
            ->db
            ->query(" UPDATE transaksi_loo SET isdisabled = '1' WHERE loo_id = '$loo_id' ");

        $u_sql = "
              SELECT DISTINCT b.region_id, b.branch_id, a.unit_id 
              FROM transaksi_loodetil AS A inner join transaksi_loo AS B ON A.loo_id = B.loo_id
              WHERE A.loo_id = '$loo_id' ";

        $q_uid = $this
            ->db
            ->query($u_sql)->result_array();

        foreach ($q_uid as $uid)
        {

            $unit_id = $uid['unit_id'];
            $region_id = $uid['region_id'];
            $branch_id = $uid['branch_id'];
            $this
                ->db
                ->query("UPDATE master_unit SET unit_state = 2 WHERE unit_id='$unit_id' AND region_id = '$region_id' AND branch_id = '$branch_id'");

        }
        //$this->db->query("delete from transaksi_loo where loo_id='$loo_id'");
        //$this->db->query("delete from transaksi_loodetil where loo_id='$loo_id'");
        //$this->db->query("delete from transaksi_loounit where loo_id='$loo_id'");
        
    }

    function viewloo($loo_id)
    {

        if (isset($loo_id))
        {
            return $this
                ->db
                ->query("
           select loo_id, convert(varchar(10),loo_date,120) AS loo_date, loo_type, unittype_id, loo_descr, skl_id,
              convert(varchar(10),loo_sdate,120) AS loo_sdate, convert(varchar(10),loo_edate,120) AS loo_edate,
              loo_term, _createby, _createdate, _modifyby, _modifydate, region_id, isapproved, isconfirm,
              LOO.branch_id, LOO.rekanan_id, LOO.rekananshipping_line, BRANCH.branch_name, REKAN.rekanan_name, 
			  BRAND.rekananshipping_name,LOO.arp_installment, LOO.arp_percentage, LOO.stamp_type, LOO.loo_comdate,
			  LOO.product_name,LOO.fitting_out,LOO.grace_period ,LOO.size_indoor ,LOO.size_outdoor,LOO.loo_tempid,
			  LOO.debtor_no,LOO.virtual_acc,LOO.payment_installment,LOO.leasedyear,LOO.guarantor,LOO.demised
           from transaksi_loo AS LOO 
              JOIN master_branch AS BRANCH ON LOO.branch_id = BRANCH.branch_id
              JOIN master_rekanan AS REKAN ON LOO.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON LOO.rekanan_id = BRAND.rekanan_id AND LOO.rekananshipping_line = BRAND.rekananshipping_line
          where LOO.loo_id='$loo_id'
       ")->result();
        }
        else
        {
            $timestamp = time();

            $now = date("Y-m-d", $timestamp);

            $result[] = (object)array(
                'loo_id' => 'auto',
                'loo_date' => $now,
                'loo_sdate' => $now,
                'loo_edate' => $now,
                'loo_term' => 0,
                'region_id' => '',
                'branch_id' => '',
                'loo_type' => '',
                'rekanan_id' => 0,
                'rekananshipping_id' => 0,
                '_createby' => '',
                '_createdate' => $now,
                '_modifyby' => '',
                '_modifydate' => $now,
                'product_name' => '',
                'fitting_out' => 0,
                'grace_period' => 0,
                'size_indoor' => 0,
                'size_outdoor' => 0,
            );

            return $result;
        }

    }

    function viewlooprint($loo_id)
    {

        if (isset($loo_id))
        {
            return $this
                ->db
                ->query("
           select top 1 LOO.loo_id, convert(varchar(10),loo_date,120) AS loo_date, 
              convert(varchar(10),loo_sdate,120) AS loo_sdate, convert(varchar(10),loo_edate,120) AS loo_edate,
              loo_term,
              LOO.branch_id, LOO.rekanan_id, LOO.rekananshipping_line, REKAN.rekanan_name, BRAND.rekananshipping_name,c.rekanancontact_name,
			  REKAN.rekanan_telp,REKAN.rekanan_email,branch.branch_name,l.lantai_name,u.unit_name,u.unit_sqm,d.loodetil_baserent
			  
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

    function confirmloo($arrCon)
    {

        $action = "return";

        if (is_array($arrCon))
        {
            if (count($arrCon) > 0)
            {
                foreach ($arrCon as $filt)
                {

                    $loo_id = $filt[0];
                    $region_id = $filt[1];
                    $branch_id = $filt[2];

                    $timestamp = time();

                    $this
                        ->db
                        ->trans_begin();

                    $this
                        ->db
                        ->query(" UPDATE transaksi_loo SET isconfirm = '1' WHERE loo_id = '$loo_id' ");

                    $u_sql = " SELECT DISTINCT unit_id FROM transaksi_loodetil WHERE loo_id = '$loo_id' ";

                    $q_uid = $this
                        ->db
                        ->query($u_sql)->result_array();

                    foreach ($q_uid as $uid)
                    {

                        $unit_id = $uid['unit_id'];
                        $this
                            ->db
                            ->query("UPDATE master_unit SET unit_state = 3 WHERE unit_id = '$unit_id' and region_id = '$region_id' and branch_id = '$branch_id' ");

                    }

                    if ($this
                        ->db
                        ->trans_status() === false)
                    {
                        //generate an error... or use the log_message() function to log your error
                        $this
                            ->db
                            ->trans_rollback();
                        return false;
                    }
                    else
                    {
                        $this
                            ->db
                            ->trans_commit();
                        return true;
                    }

                }
            }
        }

    }

    function approveloo($arrapp)
    {

        $action = "approve";

        if (is_array($arrapp))
        {
            if (count($arrapp) > 0)
            {
                foreach ($arrapp as $key)
                {

                    $loo_id = $key[0];
                    $region_id = $key[1];
                    $branch_id = $key[2];

                    $this
                        ->db
                        ->trans_begin();

                    $this
                        ->db
                        ->query(" UPDATE transaksi_loo SET isapproved = '1' WHERE loo_id = '$loo_id' ");

                    $u_sql = " SELECT DISTINCT unit_id FROM transaksi_loodetil WHERE loo_id = '$loo_id' ";

                    $q_uid = $this
                        ->db
                        ->query($u_sql)->result_array();

                    foreach ($q_uid as $uid)
                    {

                        $unit_id = $uid['unit_id'];
                        $this
                            ->db
                            ->query(" UPDATE master_unit SET unit_state = 2 WHERE unit_id='$unit_id' and region_id = '$region_id' and branch_id = '$branch_id' ");

                    }

                    if ($this
                        ->db
                        ->trans_status() === false)
                    {
                        //generate an error... or use the log_message() function to log your error
                        $this
                            ->db
                            ->trans_rollback();
                        return false;
                    }
                    else
                    {
                        $this
                            ->db
                            ->trans_commit();
                        return true;
                    }

                }
            }
        }

    }

    function unapproveloo($arrapp)
    {

        $action = "unapprove";

        if (is_array($arrapp))
        {
            if (count($arrapp) > 0)
            {
                foreach ($arrapp as $key)
                {

                    $loo_id = $key[0];
                    $region_id = $key[1];
                    $branch_id = $key[2];

                    $this
                        ->db
                        ->trans_begin();

                    $this
                        ->db
                        ->query(" UPDATE transaksi_loo SET isapproved = '0' WHERE loo_id = '$loo_id' ");

                    // $u_sql = " SELECT DISTINCT unit_id FROM transaksi_loodetil WHERE loo_id = '$loo_id' ";
                    // $q_uid = $this->db->query($u_sql)->result_array();
                    // foreach($q_uid as $uid){
                    // $unit_id = $uid['unit_id'];
                    // $this->db->query(" UPDATE master_unit SET unit_state = 2 WHERE unit_id='$unit_id' and region_id = '$region_id' and branch_id = '$branch_id' ");
                    // }
                    if ($this
                        ->db
                        ->trans_status() === false)
                    {
                        //generate an error... or use the log_message() function to log your error
                        $this
                            ->db
                            ->trans_rollback();
                        return false;
                    }
                    else
                    {
                        $this
                            ->db
                            ->trans_commit();
                        return true;
                    }

                }
            }
        }

    }

    function dataconf($uid)
    {

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

        return $this
            ->db
            ->query($sql)->result_array();
    }

    function dataapp($uid)
    {

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

        return $this
            ->db
            ->query($sql)->result_array();
    }

    function dataapplist($uid)
    {

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

        return $this
            ->db
            ->query($sql)->result_array();
    }

    function dataapplistApproved($uid)
    {

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

        return $this
            ->db
            ->query($sql)->result_array();
    }

    function dataprintconf($uid)
    {

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

        return $this
            ->db
            ->query($sql)->result_array();
    }

    function getunitloo($uid)
    {
        $sql = "select distinct c.unit_name,c.unit_sqm from dbo.transaksi_loodetil a
     inner join transaksi_loo b on a.loo_id=b.loo_id
     inner join master_unit c on b.branch_id=c.branch_id and c.unit_id=a.unit_id
     where a.loo_id='$uid' and a.agreementtype_id='4000'";
        return $this
            ->db
            ->query($sql)->result();
    }

    function gethargasewa($uid)
    {
        $sql = "select  a.loodetil_descr+' (' +c.unit_name+' )' as titleharga,a.loodetil_baserent  from dbo.transaksi_loodetil a
     inner join transaksi_loo b on a.loo_id=b.loo_id
     inner join master_unit c on b.branch_id=c.branch_id and c.unit_id=a.unit_id
     where a.loo_id='$uid' and a.agreementtype_id='4000' order by a.unit_id,a.loodetil_line asc";
        return $this
            ->db
            ->query($sql)->result();
    }

    function getservicecharge($uid)
    {
        $sql = "select SUM(loodetil_baserent) as servicecharge from transaksi_loodetil 
  where loo_id='$uid' and agreementtype_id IN ('5000','21500')";
        return $this
            ->db
            ->query($sql)->row_array();
    }

    function getpromolevy($uid)
    {
        $sql = "select SUM(loodetil_baserent) as promolevy from transaksi_loodetil 
  where loo_id='$uid' and agreementtype_id='6000'";
        return $this
            ->db
            ->query($sql)->row_array();
    }

    function getdepositr($uid)
    {
        $sql = "select loodetil_int as depositr,loodetil_baserent from transaksi_loodetil 
  where loo_id='$uid' and agreementtype_id='7000'";
        return $this
            ->db
            ->query($sql)->row_array();
    }

    function viewconfprint($loo_id)
    {

        if (isset($loo_id))
        {
            return $this
                ->db
                ->query("
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

    function getskema($id)
    {

        $qry = " SELECT A.*, B.agreementtype_name
          FROM master_sklterm A inner join master_agreementtype B ON A.skl_atype = B.agreementtype_id
          WHERE A.skl_id = '{$id}' ";

        return $this
            ->db
            ->query($qry)->result_array();
    }

    function getPassword($id)
    {

        $qry = " SELECT A.*, B.agreementtype_name
          FROM master_sklterm A inner join master_agreementtype B ON A.skl_atype = B.agreementtype_id
          WHERE A.skl_id = '{$id}' ";

        return $this
            ->db
            ->query($qry)->result_array();
    }

    function get_branch_list()
    {
        // echo var_dump($branch_name);
        // exit;
        $this
            ->db
            ->select('r.branch_id, branch_name,c.region_id,c.region_name');
        $this
            ->db
            ->from('master_regionbranch r');
        $this
            ->db
            ->join('master_branch b', 'r.branch_id = b.branch_id');
        $this
            ->db
            ->join('master_region c', 'c.region_id = r.region_id');
        $query = $this
            ->db
            ->get()
            ->result();;

        $ret[''] = 'Pilih Store :';
        if ($query)
        {
            foreach ($query as $key => $row)
            {
                $ret[$row
                    ->branch_id] = $row->branch_name;
            }
        }
        //echo var_dump($ret);
        return $ret;

    }

}

