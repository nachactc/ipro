<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	  
function getTenantLoosc($branchid,$unitid){
		  $CI =& get_instance();
		  $CI->load->model('model_map');
		  $vcontent="";
		  $vhsl=$CI->db->query("select distinct a.rekanan_id,a.rekananshipping_line,a.loo_id,c.rekananshipping_name from transaksi_loo a inner join transaksi_loodetil b
on a.loo_id=b.loo_id  inner join master_rekananshipping c
on a.rekanan_id=c.rekanan_id and a.rekananshipping_line=c.rekananshipping_line
where a.branch_id='$branchid' and b.unit_id='$unitid' and a.isapproved='1'");
		foreach ($vhsl->result() as $sub) {
			$vnama=$sub->rekananshipping_name;
			$vid=$sub->loo_id;
			$vcontent .="<tr>";
   			$vcontent .="<td>$vid</td>";
   			$vcontent .="<td>$vnama</td>";
  			$vcontent .="</tr>";
			
		}
		return $vcontent;
		  
	  }
	  
	  function getspecunit($unitid){
		  $CI =& get_instance();
		  $CI->load->model('model_map');
		  $rsq=$CI->db->query("select top 1 agreement_id,isnull(agreementdetil_space,0) as agreementdetil_space from transaksi_agreementdetil where unit_id='$unitid'
		union
		select top 1 agreement_id,isnull(agreementdetil_space,0) as agreementdetil_space  from transaksi_agreementtempdetil where unit_id='$unitid'")->row_array();

		$space=$rsq['agreementdetil_space'];
		  
		  return $space;
		  
	  }
	 function showTabelatm($looid){
		  
		$CI =& get_instance();
		$loounit=$CI->db->query("select * from  transaksi_loounit where loo_id='$looid' "); 

		$vloounit = $loounit->result(); 
		
		$nom=1;
		foreach ($vloounit as $rowloounit) {
				
		$CI_sub =& get_instance();
		$regionid=$rowloounit->region_id;
		$branchid=$rowloounit->branch_id;     
					
		$subitem=$CI_sub->db->query("SELECT a.loodetil_line,a.agreementtype_id,a.loodetil_baserent,b.unit_nameshort as unit_name,b.branch_id,b.unit_sqm,c.lantai_name,h.loo_term,d.branch_name
FROM   transaksi_loodetil a inner join transaksi_loo h on a.loo_id=h.loo_id
inner join master_unit b on a.unit_id=b.unit_id
inner join master_lantai c on b.lantai_id=c.lantai_id
inner join master_branch d on d.branch_id=b.branch_id
WHERE a.loo_id = '$looid' and b.branch_id='$branchid' and a.agreementtype_id IN ('20000','25000','9600')
and b.unit_id IN (select unit_id from transaksi_loounit where loo_id = '$looid' and branch_id='$branchid')
order by CHARINDEX(agreementtype_id, '20000,9600,25000')");




		///$vsubgroupqry=$subitem->result(); 
		
		$jml=$subitem->num_rows();
		 if ($subitem->num_rows() > 0) {
			 $i=1;  
		 echo "<tr>";
		   foreach ($subitem->result() as $sub) {
			   $branch_name=$sub->branch_name;
			   $unit_name=$sub->unit_name;
			   $lantai_name=$sub->lantai_name;
			   $unit_sqm=$sub->unit_sqm;
			   $loodetil_baserent=number_format($sub->loodetil_baserent,0);
			   $loo_term=$sub->loo_term;
			   $agreementtype_id=$sub->agreementtype_id;
			   
			   if ($i==1){
			    echo "<td>$nom</td>";
    			echo "<td>$branch_name</td>";
   				echo "<td>$unit_name</td>";
   				echo "<td>$unit_sqm</td>";
   				echo "<td>$loodetil_baserent</td>";
				
			   }
			   if (($i==2) and ($jml==1) and ($agreementtype_id=='9600') ){
				  echo "<td>$loodetil_baserent</td>"; 
			   }
			   if (($i==2) and ($i!==$jml) and ($agreementtype_id=='9600') ){
				  echo "<td>$loodetil_baserent</td>"; 
			   }else if (($i==2) and ($i!==$jml) and ($agreementtype_id!=='9600') ){
				  echo "<td>&nbsp;</td>"; 
			   }else if (($i==2) and ($i==$jml) and ($agreementtype_id!=='9600') ){
				  echo "<td>&nbsp;</td>"; 
			   }
				
			   if ($i==$jml){
    			echo "<td>$loodetil_baserent</td>";
    			echo "<td>$loo_term</td>";
			   }
			   $i++;
			}
				echo "/<tr>";
				
		}
		$nom++;
	}
 }

function tanggal_indo($tanggal)
{
	$bulan = array (1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
	$split = explode('-', $tanggal);
	return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
}

 function showTabelbts($looid){
	
		  
		$CI =& get_instance();
		$loounit=$CI->db->query("select  a.*,b.rekananshipping_name from transaksi_loounit a
inner join master_rekananshipping b on a.rekanan_id=b.rekanan_id and a.rekananshipping_line=b.rekananshipping_line
 where a.loo_id='$looid' "); 

		$vloounit = $loounit->result(); 
		
		$nom=1;
		foreach ($vloounit as $rowloounit) {
				
		$CI_sub =& get_instance();
		$regionid=$rowloounit->region_id;
		$branchid=$rowloounit->branch_id; 
		$rekananshipping_name=$rowloounit->rekananshipping_name;   
		$rekananshipping_line=$rowloounit->rekananshipping_line;   
					
		$subitem=$CI_sub->db->query("SELECT distinct a.agreementtype_id,a.loodetil_baserent,b.unit_nameshort as unit_name,b.branch_id,b.unit_sqm,a.loodetil_int,
		h.loo_descr,a.loodetil_descr,e.loounit_size
FROM   transaksi_loodetil a inner join transaksi_loo h on a.loo_id=h.loo_id
inner join master_unit b on a.unit_id=b.unit_id
inner join master_branch d on d.branch_id=b.branch_id
inner join transaksi_loounit e on a.loo_id=e.loo_id and a.region_id=e.region_id and e.branch_id=a.branch_id and a.rekanan_id=e.rekanan_id and
a.rekananshipping_line=e.rekananshipping_line and a.unit_id=e.unit_id
WHERE a.loo_id = '$looid' and b.branch_id='$branchid' and a.rekananshipping_line='$rekananshipping_line'");

		
		$jml=$subitem->num_rows();
		$b=0;
		echo "<tr><td colspan='4'><strong><u>$rekananshipping_name:</u></strong></td></tr>";
		 if ($subitem->num_rows() > 0) {
		 
		   foreach ($subitem->result() as $sub) {
			
			   $unit_name=$sub->unit_name;
			   $unit_sqm=$sub->unit_sqm;
			   $loodetil_baserent=$sub->loodetil_baserent;
			   $vloodetil_baserent=number_format($sub->loodetil_baserent,0);
			   $loodetil_baserent=$loodetil_baserent;
			   $agreementtype_id=$sub->agreementtype_id;
			   
			   $sdate=tanggal_indo($rowloounit->loounit_sdate);
			   $edate=tanggal_indo($rowloounit->loounit_edate);
			   
			   $loodetil_totsewa=$loodetil_baserent * $sub->loodetil_int;
			   $loodetil_totsewa=number_format($loodetil_totsewa,0);
			   $loounit_size=number_format($sub->loounit_size,0);
			   

  echo "<tr>";
    echo "<td width='20' valign='top'>1.</td>";
    echo "<td width='194' valign='top'>Level / Unit</td>";
    echo "<td width='16' valign='top'>:</td>";
    echo "<td width='505' valign='top'>$unit_name</td>";
  echo "</tr>";
  echo "<tr>";
    echo "<td valign='top'>2.</td>";
    echo "<td valign='top'>Luas Area</td>";
    echo "<td valign='top'>:</td>";
    echo "<td valign='top'>$loounit_size M2</td>";
  echo "</tr>";
  echo "<tr>";
    echo "<td valign='top'>3.</td>";
    echo "<td valign='top'>Periode sewa</td>";
    echo "<td valign='top'>:</td>";
    echo "<td valign='top'>$sdate - $edate</td>";
  echo "</tr>";
  echo "<tr>";
    echo "<td valign='top'>4.</td>";
    echo "<td valign='top'>Biaya sewa</td>";
    echo "<td valign='top'>:</td>";
    echo "<td valign='top'>$vloodetil_baserent $sub->loodetil_descr</td>";
  echo "</tr>";
 
  
  echo "<tr>";
    echo "<td valign='top'>5.</td>";
    echo "<td valign='top'>Total Sewa</td>";
    echo "<td valign='top'>:</td>";
    echo "<td valign='top'>$loodetil_totsewa</td>";
  echo "</tr>";
  echo "<tr>";
    echo "<td valign='top'>6.</td>";
    echo "<td valign='top'>Biaya Utilitas</td>";
    echo "<td valign='top'>:</td>";
    echo "<td align='justify' valign='top'>Berdasarkan pemakaian bulanan yang tercatat pada KWH Meter 
ditambah biaya administrasi 10% dan PPN 10%
</td>";
  echo "</tr>";
  echo "<tr>";
    echo "<td valign='top'>7.</td>";
    echo "<td valign='top'>Cara pembayaran </td>";
    echo "<td valign='top'>:</td>";
    echo "<td align='justify' valign='top'>$sub->loo_descr</td>";
  echo "</tr>";
  
echo "<tr>";
    echo "<td>&nbsp;</td>";
    echo "<td>&nbsp;</td>";
    echo "<td>&nbsp;</td>";
    echo "<td>&nbsp;</td>";
  echo "</tr>";			   

			$b++;
		   }
				
		}
		$nom++;
	}
 }
	
function showloola_new($cbsemester,$cboyear){
		  
		$CI =& get_instance();
		$semesterbranch=$CI->db->query("select a.branch_id,b.branch_name from master_semesterbranch a 
  inner join master_branch b on a.branch_id=b.branch_id where a.semester_id='$cbsemester' and a.semester_year='$cboyear'"); 

		$vsemesterbranch= $semesterbranch->result(); 
		if ($cboyear==""){
			$prosentenant='0';
		}else{
			$prosentenant='100';
		}
		
		$nom=1;
		$tot=0;
		foreach ($vsemesterbranch as $rowsemesterbranch) {
				
			$CI_sub =& get_instance();
			$branchid=$rowsemesterbranch->branch_id;  
			$branch_name=$rowsemesterbranch->branch_name;   
					
			$subitem=$CI_sub->db->query(" select count(distinct f.rekanan_id) as jml1
 					from master_region a inner join
					master_regionbranch b on a.region_id=b.region_id
 					inner join master_branch c on b.branch_id=c.branch_id
 					inner join transaksi_agreement d on d.region_id=a.region_id 
 					and d.branch_id=b.branch_id and d.agreement_isclosed=0
 					inner join transaksi_agreementdetil e on d.agreement_id=e.agreement_id
 					inner join master_rekanan f on f.rekanan_id=d.rekanan_id
 					where d.branch_id='$branchid'")->row_array();
 
 			$subitem2=$CI_sub->db->query("select  count(distinct f.rekanan_id) as jml2
 					from master_region a inner join
 					master_regionbranch b on a.region_id=b.region_id
 					inner join master_branch c on b.branch_id=c.branch_id
 					inner join transaksi_agreementtemp d on d.region_id=a.region_id 
 					and d.branch_id=b.branch_id and d.agreement_isclosed=0
 					inner join transaksi_agreementtempdetil e on d.agreement_id=e.agreement_id
 					inner join master_rekanan f on f.rekanan_id=d.rekanan_id
 					where d.branch_id='$branchid'")->row_array();

			$jml=$subitem['jml1']+$subitem2['jml2'];
			$tot=$tot+$jml;
			    echo "<tr>";
    			echo "<td align='center'>$nom</td>";
    			echo "<td>$branch_name</td>";
   				echo "<td valign='middle' align='center'>$jml</td>";
    			echo "<td align='center'>&nbsp;</td>";
    			echo "<td align='center'>&nbsp;</td>";
    			echo "<td align='center'>&nbsp;</td>";
    			echo "<td align='center'>&nbsp;</td>";
    			echo "<td align='center'>&nbsp;</td>";
  				echo "</tr>";
				$nom++;
		}
		
		 echo "<tr>";
    echo "<td colspan='2' rowspan='3' align='center'>Total</td>";
    echo "<td valign='middle' align='center'>$tot</td>";
    echo "<td>&nbsp;</td>";
    echo "<td>&nbsp;</td>";
    echo "<td>&nbsp;</td>";
    echo "<td>&nbsp;</td>";
    echo "<td>&nbsp;</td>";
  echo "</tr>";
  echo "<tr>";
    echo "<td valign='middle' align='center'>$prosentenant%</td>";
    echo "<td>&nbsp;</td>";
    echo "<td>&nbsp;</td>";
    echo "<td>&nbsp;</td>";
    echo "<td>&nbsp;</td>";
    echo "<td>&nbsp;</td>";
  echo "</tr>";
  echo "<tr>";
    echo "<td valign='middle' align='center'>A</td>";
    echo "<td align='center'>B</td>";
    echo "<td align='center'>C</td>";
    echo "<td align='center' colspan='3'>D</td>";
    echo "</tr>";
 }


function showloidp($cbsemester,$cboyear){
		  
		$CI =& get_instance();
		$semesterbranch=$CI->db->query("select a.branch_id,b.branch_name from master_semesterbranch a 
  inner join master_branch b on a.branch_id=b.branch_id where a.semester_id='$cbsemester' and a.semester_year='$cboyear'"); 

		$vsemesterbranch= $semesterbranch->result(); 
		if ($cboyear==""){
			$prosentenant='0';
		}else{
			$prosentenant='100';
		}
		
		$nom=1;
		$tot=0;
		foreach ($vsemesterbranch as $rowsemesterbranch) {
				
			$CI_sub =& get_instance();
			$branchid=$rowsemesterbranch->branch_id;  
			$branch_name=$rowsemesterbranch->branch_name;   
					
			$subitem=$CI_sub->db->query(" select count(distinct f.rekanan_id) as jml1
 					from master_region a inner join
					master_regionbranch b on a.region_id=b.region_id
 					inner join master_branch c on b.branch_id=c.branch_id
 					inner join transaksi_agreement d on d.region_id=a.region_id 
 					and d.branch_id=b.branch_id and d.agreement_isclosed=0
 					inner join transaksi_agreementdetil e on d.agreement_id=e.agreement_id
 					inner join master_rekanan f on f.rekanan_id=d.rekanan_id
 					where d.branch_id='$branchid'")->row_array();
 
 			$subitem2=$CI_sub->db->query("select  count(distinct f.rekanan_id) as jml2
 					from master_region a inner join
 					master_regionbranch b on a.region_id=b.region_id
 					inner join master_branch c on b.branch_id=c.branch_id
 					inner join transaksi_agreementtemp d on d.region_id=a.region_id 
 					and d.branch_id=b.branch_id and d.agreement_isclosed=0
 					inner join transaksi_agreementtempdetil e on d.agreement_id=e.agreement_id
 					inner join master_rekanan f on f.rekanan_id=d.rekanan_id
 					where d.branch_id='$branchid'")->row_array();

			$jml=$subitem['jml1']+$subitem2['jml2'];
			$tot=$tot+$jml;
				echo "<tr>";
    			echo "<td align='center'>$nom</td>";
    			echo "<td>$branch_name</td>";
   				echo "<td valign='middle' align='center'>$jml</td>";
    			echo "<td align='center'>&nbsp;</td>";
   				echo "<td align='center'>&nbsp;</td>";
    			echo "<td align='center'>&nbsp;</td>";
    			echo "<td align='center'>&nbsp;</td>";
   			 	echo "<td align='center'>&nbsp;</td>";
    			echo "<td  align='center' valign='middle'>&nbsp;</td>";
    			echo "<td  align='center' valign='middle'>&nbsp;</td>";
    			echo "<td  align='center' valign='middle'>&nbsp;</td>";
    			echo "<td  align='center' valign='middle'>&nbsp;</td>";
				echo "</tr>";
				$nom++;
		}
		
	echo "<tr>";
    echo "<td colspan='2' rowspan='2' align='center'>TOTAL</td>";
    echo "<td align='center' valign='middle'>$tot</td>";
    echo "<td align='center'>&nbsp;</td>";
    echo "<td align='center'>&nbsp;</td>";
    echo "<td align='center'>&nbsp;</td>";
    echo "<td align='center'>&nbsp;</td>";
    echo "<td align='center'>&nbsp;</td>";
    echo "<td  align='center' valign='middle'>&nbsp;</td>";
    echo "<td  align='center' valign='middle'>&nbsp;</td>";
    echo "<td  align='center' valign='middle'>&nbsp;</td>";
    echo "<td  align='center' valign='middle'>&nbsp;</td>";
  echo "</tr>";
  echo "<tr>";
    echo "<td align='center' valign='middle'>$prosentenant%</td>";
    echo "<td align='center'>&nbsp;</td>";
    echo "<td align='center'>&nbsp;</td>";
    echo "<td align='center'>&nbsp;</td>";
    echo "<td align='center'>&nbsp;</td>";
    echo "<td align='center'>&nbsp;</td>";
    echo "<td  align='center' valign='middle'>&nbsp;</td>";
    echo "<td  align='center' valign='middle'>&nbsp;</td>";
    echo "<td  align='center' valign='middle'>&nbsp;</td>";
    echo "<td  align='center' valign='middle'>&nbsp;</td>";
  echo "</tr>";
  echo "<tr>";
    echo "<td colspan='2' align='center' style='border-bottom:0;' >&nbsp;</td>";
    echo "<td align='center' valign='middle'>A</td>";
    echo "<td align='center'>B</td>";
    echo "<td colspan='3' align='center'>A</td>";
    echo "<td align='center'>&nbsp;</td>";
    echo "<td colspan='3'  align='center' valign='middle'>A</td>";
    echo "<td  align='center' valign='middle'>&nbsp;</td>";
  echo "</tr>";
 }


function showloola_newtenant($cboyear){
		$CIkode =& get_instance();
		$sqlkode=$CIkode->db->query("select * FROM master_groupbranch");
		$vsqlkode= $sqlkode->result(); 
		foreach ($vsqlkode as $rowkode) {
			$kodegroup=$rowkode->group_branchid;
		 	 echo "<tr>";
    			echo "<td colspan='8' align='left'>$kodegroup</td>";
    		echo "</tr>";
		  
		$CI =& get_instance();
		$semesterbranch=$CI->db->query("select a.branch_id,b.branch_name from master_semesterbranch a 
  inner join master_branch b on a.branch_id=b.branch_id where a.semester_year='$cboyear' and group_branchid='$kodegroup'"); 

		$vsemesterbranch= $semesterbranch->result(); 
		if ($cboyear==""){
			$prosentenant='0';
		}else{
			$prosentenant='100';
		}
		
		$nom=1;
		$tot=0;
		foreach ($vsemesterbranch as $rowsemesterbranch) {
				
			$CI_sub =& get_instance();
			$branchid=$rowsemesterbranch->branch_id;  
			$branch_name=$rowsemesterbranch->branch_name;   
					
			$subitem=$CI_sub->db->query(" select count(distinct f.rekanan_id) as jml1
 					from master_region a inner join
					master_regionbranch b on a.region_id=b.region_id
 					inner join master_branch c on b.branch_id=c.branch_id
 					inner join transaksi_agreement d on d.region_id=a.region_id 
 					and d.branch_id=b.branch_id and d.agreement_isclosed=0
 					inner join transaksi_agreementdetil e on d.agreement_id=e.agreement_id
 					inner join master_rekanan f on f.rekanan_id=d.rekanan_id
 					where d.branch_id='$branchid' and d.agreement_isrenewal=0")->row_array();
 
 			$subitem2=$CI_sub->db->query("select  count(distinct f.rekanan_id) as jml2
 					from master_region a inner join
 					master_regionbranch b on a.region_id=b.region_id
 					inner join master_branch c on b.branch_id=c.branch_id
 					inner join transaksi_agreementtemp d on d.region_id=a.region_id 
 					and d.branch_id=b.branch_id and d.agreement_isclosed=0
 					inner join transaksi_agreementtempdetil e on d.agreement_id=e.agreement_id
 					inner join master_rekanan f on f.rekanan_id=d.rekanan_id
 					where d.branch_id='$branchid' and d.agreement_isrenewal=0")->row_array();

			$jml=$subitem['jml1']+$subitem2['jml2'];
			$tot=$tot+$jml;
			    echo "<tr>";
    			echo "<td align='center'>$nom</td>";
    			echo "<td>$branch_name</td>";
   				echo "<td valign='middle' align='center'>$jml</td>";
    			echo "<td align='center'>&nbsp;</td>";
    			echo "<td align='center'>&nbsp;</td>";
    			echo "<td align='center'>&nbsp;</td>";
    			echo "<td align='center'>&nbsp;</td>";
    			echo "<td align='center'>&nbsp;</td>";
  				echo "</tr>";
				$nom++;
		}
		
		  echo "<tr>";
    echo "<td colspan='2'  align='center'>Total $kodegroup</td>";
    echo "<td valign='middle' align='center'>$tot</td>";
    echo "<td>&nbsp;</td>";
    echo "<td>&nbsp;</td>";
    echo "<td>&nbsp;</td>";
    echo "<td>&nbsp;</td>";
    echo "<td>&nbsp;</td>";
  echo "</tr>";

 }
  echo "<tr>";
    echo "<td colspan='2' rowspan='3' align='center'>Total</td>";
    echo "<td valign='middle' align='center'>$tot</td>";
    echo "<td>&nbsp;</td>";
    echo "<td>&nbsp;</td>";
    echo "<td>&nbsp;</td>";
    echo "<td>&nbsp;</td>";
    echo "<td>&nbsp;</td>";
  echo "</tr>";
  echo "<tr>";
    echo "<td valign='middle' align='center'>$prosentenant%</td>";
    echo "<td>&nbsp;</td>";
    echo "<td>&nbsp;</td>";
    echo "<td>&nbsp;</td>";
    echo "<td>&nbsp;</td>";
    echo "<td>&nbsp;</td>";
  echo "</tr>";
  echo "<tr>";
    echo "<td valign='middle' align='center'>A</td>";
    echo "<td align='center'>B</td>";
    echo "<td align='center'>C</td>";
    echo "<td align='center' colspan='3'>C</td>";
    echo "</tr>";
}
	
	 
          
     