<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_unit extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
	 function qry_alldatadialog($limit,$top,$sWhere){
	   $qry="WITH CTE AS (
 				select top $limit *,ROW_NUMBER() OVER (ORDER BY schedulebooking_id asc) as RowNumber 
				from transaksi_schedulebookingdetil $sWhere)
		SELECT * FROM CTE WHERE RowNumber > $top";
	   return $this->db->query($qry)->result_array();	   
   }
   
   function qry_filtereddialog($sWhere){
	   $qry="select count(schedulebooking_id) as jml from transaksi_schedulebookingdetil $sWhere";
		return $this->db->query($qry)->row_array();
	   
   }
   
   function qry_totalalldialog(){
	   $qry="select count(schedulebooking_id) as jml from transaksi_schedulebookingdetil";
		return $this->db->query($qry)->row_array();
	   
   }
   
    function qry_alldatalist($limit,$top,$sWhere){
		
	   $qry="	SELECT * FROM (					   
		SELECT top $limit * from (	 
		SELECT a.*,ROW_NUMBER() OVER (ORDER BY a._createdate desc) as RowNumber,
				(CASE ISNULL(unit_state,0) WHEN 0 THEN 'Available' WHEN 2 THEN 'SOLD' WHEN 4 THEN  'DISABLED' ELSE 'LA RETURN' END) as status, TYPE.unittype_name, REGION.region_nameshort, BRANCH.branch_name,LANTAI.lantai_name,
		(CASE ISNULL(unit_state,0) WHEN 2 
		THEN (SELECT top 1 loo_id FROM transaksi_loounit WHERE unit_id = a.unit_id) 
		WHEN 3 
		THEN (SELECT top 1 loo_id FROM transaksi_loounit WHERE unit_id = a.unit_id) 
		END) as refid,
				(CASE ISNULL(unit_state,0) WHEN 2 THEN ( 
											Select top 1 b_.rekanan_name From transaksi_loounit _a
											LEFT join master_rekanan b_ on _a.rekanan_id = b_.rekanan_id
											WHERE a.unit_id = _a.unit_id ) 
											WHEN 3 THEN
											( 
											Select top 1 b_.rekanan_name From transaksi_loounit _a
											LEFT join master_rekanan b_ on _a.rekanan_id = b_.rekanan_id
											WHERE a.unit_id = _a.unit_id ) 
											END) as rekanan,
				(CASE ISNULL(unit_state,0) WHEN 2 THEN ( 
											Select  top 1 b_.rekananshipping_name From transaksi_loounit _a
											LEFT join master_rekananshipping b_ on _a.rekanan_id = b_.rekanan_id and _a.rekananshipping_line = b_.rekananshipping_line
											WHERE  a.unit_id = _a.unit_id) 
											WHEN 3 THEN ( 
											Select  top 1 b_.rekananshipping_name From transaksi_loounit _a
											LEFT join master_rekananshipping b_ on _a.rekanan_id = b_.rekanan_id and _a.rekananshipping_line = b_.rekananshipping_line
											WHERE  a.unit_id = _a.unit_id) 
											END) as brand 
      FROM master_unit a 
      JOIN master_unittype AS TYPE ON convert(int,a.unittype_id) = convert(int,TYPE.unittype_id) 
      JOIN master_region AS REGION ON a.region_id = REGION.region_id
      JOIN master_branch AS BRANCH ON a.branch_id = BRANCH.branch_id
      JOIN master_lantai AS LANTAI ON a.lantai_id = LANTAI.lantai_id 
	   )v
	  $sWhere 
      )  CTE
    WHERE CTE.RowNumber >  $top 
	";
	   $output = $this->db->query($qry);
	   //echo $this->db->last_query();
	   return $output->result_array();	
	   
   }
   
    function qry_filteredlist($sWhere){
	 
	  
	   $qry="	SELECT count(*) as jml FROM (					   
		SELECT   * from (	 
		SELECT a.*,ROW_NUMBER() OVER (ORDER BY a._createdate desc) as RowNumber,
				(CASE ISNULL(unit_state,0) WHEN 0 THEN 'Available' WHEN 2 THEN 'SOLD' WHEN 4 THEN  'DISABLED' ELSE 'LA RETURN' END) as status, TYPE.unittype_name, REGION.region_nameshort, BRANCH.branch_name,LANTAI.lantai_name,
		(CASE ISNULL(unit_state,0) WHEN 2 
		THEN (SELECT top 1 loo_id FROM transaksi_loounit WHERE unit_id = a.unit_id) 
		WHEN 3 
		THEN (SELECT top 1 loo_id FROM transaksi_loounit WHERE unit_id = a.unit_id) 
		END) as refid,
					(CASE ISNULL(unit_state,0) WHEN 2 THEN ( 
											Select top 1 b_.rekanan_name From transaksi_loounit _a
											LEFT join master_rekanan b_ on _a.rekanan_id = b_.rekanan_id
											WHERE a.unit_id = _a.unit_id ) 
											WHEN 3 THEN
											( 
											Select top 1 b_.rekanan_name From transaksi_loounit _a
											LEFT join master_rekanan b_ on _a.rekanan_id = b_.rekanan_id
											WHERE a.unit_id = _a.unit_id ) 
											END) as rekanan,
				(CASE ISNULL(unit_state,0) WHEN 2 THEN ( 
											Select  top 1 b_.rekananshipping_name From transaksi_loounit _a
											LEFT join master_rekananshipping b_ on _a.rekanan_id = b_.rekanan_id and _a.rekananshipping_line = b_.rekananshipping_line
											WHERE  a.unit_id = _a.unit_id) 
											WHEN 3 THEN ( 
											Select  top 1 b_.rekananshipping_name From transaksi_loounit _a
											LEFT join master_rekananshipping b_ on _a.rekanan_id = b_.rekanan_id and _a.rekananshipping_line = b_.rekananshipping_line
											WHERE  a.unit_id = _a.unit_id) 
											END) as brand 
      FROM master_unit a 
      JOIN master_unittype AS TYPE ON convert(int,a.unittype_id) = convert(int,TYPE.unittype_id) 
      JOIN master_region AS REGION ON a.region_id = REGION.region_id
      JOIN master_branch AS BRANCH ON a.branch_id = BRANCH.branch_id
      JOIN master_lantai AS LANTAI ON a.lantai_id = LANTAI.lantai_id 
	   )v
	  $sWhere 
      )  CTE 
	";
	   //$qry="select count(a.unit_id) as jml from master_unit a inner join master_branch BRANCH on a.branch_id=BRANCH.branch_id $sWhere";
	   $output = $this->db->query($qry);
	   //echo '-->'.$qry;
	   return $output->row_array();	 
	   
   }
   
    function qry_totalalllist(){
	   $qry="select count(unit_id) as jml from master_unit";
		return $this->db->query($qry)->row_array();
	   
   }
   
    function insertloo($loo_date, $loo_sdate, $loo_edate, $loo_term, $_createby, $_modifyby, $region, $branch, 
        $loodetil_line,$unit_id,$agreementtype_id,$loodetil_baserent){

      $idx=$this->model_loo->insertloo($loo_date, $loo_sdate, $loo_edate, $loo_term, $_createby, $_modifyby, $region, $branch, 
        $loodetil_line,$unit_id,$agreementtype_id,$loodetil_baserent);
		    
        $loo_id = generate_id_string('TPC','CO', 10, 'sequencer_jurnal');    
        $timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);     
        $check = $this->db->query("
                 insert into transaksi_loo
                     (loo_id, loo_date, loo_sdate, loo_edate, loo_term, _createby, _createdate, _modifyby, _modifydate, region_id , branch_id, 
                      loodetil_line,$unit_id,$agreementtype_id,$loodetil_baserent)	
                 values
                     ('$loo_id','$loo_date', '$loo_sdate', '$loo_edate', '$loo_term, '$descr', 0,'$_createby','$now','$_modifyby','$now','$region','$branch')");     
			
			foreach($coll_line as $key => $n){
				$tcoll_line=$coll_line[$key];
				$tcoll_descr=$coll_descr[$key];
				$tcoll_amount=$coll_amount[$key];
				$tref_id=$ref_id[$key];
				$tref_line=$ref_line[$key];
    			$tcoll_amount= str_replace(',', '',$tcoll_amount);
              	$this->db->query("
                   insert into web_colldetil
                       (coll_id, coll_line, coll_descr, coll_amount, ref_id, ref_line)    
                   values
                       ('$coll_id', $tcoll_line, '$tcoll_descr', $tcoll_amount, '$tref_id', $tref_line)");	
			}
			
			return $coll_id;
			  
    }
 
	function updateunit($unit_id,$unit_name, $unit_sqm, $_createby, $_modifyby, $region, $branch, $unit_coordinate,$unit_coordtype,$unittype_id,$cbofloor){   	
  		$timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp); 
		
		$id_old = $this->db->query("select * from master_unit where unit_id = '$unit_id'")->row();
		$get_unittype_old = $id_old->unittype_id;
		$time_old =$id_old->_createdate; 
		$branch_old = $id_old->branch_id; 
		// echo $get_unittype_old;
		// echo '<br/>--';
		// echo $unittype_id;
		// exit;
		if($get_unittype_old != $unittype_id || $branch_old != $branch)
		{
			$this->db->query("delete from master_unit where unit_id = '$unit_id'");
			$this->saveunit($unit_name,$unit_sqm,$region,$branch,$unit_coordinate,$unit_coordtype,$cbofloor,$unittype_id,TRUE,$time_old);
		}
		else
		{
			$this->db->query("
				update master_unit
				set unit_name = '$unit_name', 
				unit_sqm = $unit_sqm,  
					_modifyby = '$_modifyby', 
					_modifydate = '$now', 
					region_id = '$region' , 
					branch_id = '$branch',
					unit_coordtype = '$unit_coordtype', 
					unit_coordinate = '$unit_coordinate',
					unittype_id = '$unittype_id',
					lantai_id = '$cbofloor'
				where unit_id = '$unit_id'
			");	
		}
        	

    }
	
	function saveunit($unit_name,$unit_sqm,$region,$branch,$unit_coordinate,$unit_coordtype,$cbofloor,$cbounittype,$bypass=false,$time_old=NULL){ 
	// $rjml=$this->db->query("
	// select count(unit_id) as jml from master_unit where branch_id='$branch'
	// and unittype_id = '$cbounittype'
	// ")->row_array();
	// $rjml=$this->db->query("
	// select ISNULL(RIGHT(max(cast(unit_id as decimal)),2),0) AS jml from master_unit where branch_id='$branch'
	// and unittype_id = '$cbounittype'
	// ")->row_array();
	$rjml=$this->db->query("
	select lastid from sequencer_unit  
	where branch_id='$branch' 
	")->row_array();
	// echo $this->db->last_query();
	// exit;
	$tot= ($rjml['lastid'])+1;
	//echo $tot;exit;
	/**
	03000001500104
	030-->region
	0000150-->branch
	01-->unit type
	10001-->sequencer otomatis
	**/
	//echo $branch;
	$unittype = sprintf("%'.02.d", $cbounittype);
	$tot = sprintf("%'.05.d", $tot); 
	//$tot = $tot == '99' ? '00' : $tot; 
	//echo '<br/>';
	//echo $tot ;
	//echo '<br/>';
	
		$username =  $this->session->userdata('user_fullname');
		$timestamp = time();
		$date = date("Y-m-d H:i:s", $timestamp); 
        $unit_id=$region.$branch.$unittype.$tot;
		// echo $unit_id;
		//exit;
		if($bypass==false)
		{
			$this->db->query("
            insert into master_unit(unit_id,unit_name,unit_sqm,region_id,branch_id,unit_coordinate,unit_coordtype,lantai_id,unit_nameshort,unit_state,unittype_id,_createby,_createdate)
			values ('$unit_id','$unit_name','$unit_sqm','$region','$branch','$unit_coordinate','$unit_coordtype','$cbofloor','$unit_name',0,'$cbounittype','$username','$date')");
		}
		else
		{
			$this->db->query("
            insert into master_unit(unit_id,unit_name,unit_sqm,region_id,branch_id,unit_coordinate,unit_coordtype,lantai_id,unit_nameshort,unit_state,unittype_id,_createby,_createdate,_modifyby,_modifydate)
			values ('$unit_id','$unit_name','$unit_sqm','$region','$branch','$unit_coordinate','$unit_coordtype','$cbofloor','$unit_name',0,'$cbounittype','$username','$time_old','$username','$date')");
		}
		$this->db->query("
		update sequencer_unit
		set	lastid = '$tot'   
		where branch_id='$branch' 
		");

    }
	
	function get_floor(){

        $this->db->select('lantai_id, lantai_name');
        $query = $this->db->get('master_lantai');

        return $query->result();
    }
	
	function get_unittype(){

        $this->db->select('unittype_id, unittype_name');
        $query = $this->db->get('master_unittype');

        return $query->result();
    }
	
	function deleteunit($unit_id){
		//$this->db->query("delete from master_unit where unit_id='$unit_id'");
		/*$this->db->query("delete from web_colldetil where coll_id='$coll_id'");*/
		$this->db->where('unit_id', $unit_id);
        $this->db->delete('master_unit');
	}
    
    function viewunit($unit_id){     

     if (isset($unit_id)){
        return $this->db->query("
           select unit_id, unit_name, unit_part, unit_sqm, unit_parent, unit_path, unit_state, unit_coordinate, unit_coordtype, unittype_id, _createby, _createdate, _modifyby, _modifydate, region_id, branch_id, lantai_id
           from master_unit 
           where master_unit.unit_id='$unit_id'
       ")->result();
     }else{         
       $timestamp = time();
      
       $now = date("Y-m-d", $timestamp);  

       $result[] = (object) array(                        
                        'unit_id'         =>'auto',
                        'unit_name'       => '',
                        'unit_part'       => '',
                        'unit_sqm'        => '',
                        'unit_parent'     => '',
                        'unit_path'       => '',
                        'unit_state'      => 0,
                        'unit_coordinate' => '',
                        'unit_coordtype'  => '',
                        'unittype_id'     => 0,
                        'region_id'       => 0,
                        'branch_id'       => 0,
                        'lantai_id'       => 0,
                        '_createby'       => '',
                        '_createdate'     => $now,
                        '_modifyby'       => '',
                        '_modifydate'     => $now
       );

       return $result;
     }

   }
    
	function cek_unit_status($unit_id)
	{
		$sql = "SELECT COUNT(*) as jml FROM transaksi_loounit WHERE unit_id = '$unit_id'";
		$result = $this->db->query($sql)->row()->jml;
		 
		if($result == 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
     
	function get_branch_dlg($branch_name="")
	{ 
		// echo var_dump($branch_name);
		// exit;
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
		
		 // $ret ['']= 'Pilih Store :';
        // if($result)
        // {
            // foreach ($result as $key => $row)
            // {
                // $ret [$row->branch_id] = $row->branch_name;
            // }
        // }
        //echo var_dump($ret);
        return $result; 
		
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