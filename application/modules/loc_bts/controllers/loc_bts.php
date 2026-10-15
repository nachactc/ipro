<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loc_bts extends CI_Controller{

    function __construct(){

        parent::__construct();

        $this->load->model('model_loc_bts');
		$this->load->library('breadcrumbcomponent');
    }

    function index(){
        redirect('loc_bts/loc_bts/loclist');
    }
    function globalsearch_dialog(){ 
		$arcari=array('unit_id','unit_name', 'region_id', 'branch_id');
		return $arcari;
	}
  function globalsearch_rekanan(){
        $arcari=array('rekanan_name','rekananshipping_name');
        return $arcari;
    }

    function globalsearch_list(){
  		$arcari=array('loc_id',  'CTE.region_id','CTE.rekanan_id','BRANCH.branch_name','REKAN.rekanan_name','BRAND.rekananshipping_name');
  		return $arcari;
  	}
    function globalsearch_schema(){
        $arcari=array('rekanan_id', 'rekananshipping_line', 'loo_id');
        return $arcari;
    }
    function initialize_grid($qry_alldata,$qry_filtered,$qry_totalall,$arcari,$cariOptional = ''){
  		$aColumns = $arcari;

  		$sOrder = "";
  		if ( isset( $_GET['iSortCol_0'] ) ) {
  			$sOrder = "ORDER BY  ";
  			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ) {
  				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) {
  					$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
  						".addslashes( $_GET['sSortDir_'.$i] ) .", ";
  				}
  			}
  			$sOrder = substr_replace( $sOrder, "", -2 );
  			if ( $sOrder == "ORDER BY" ) {
  				$sOrder = "";
  			}
  		}

  		$sWhere = "";
  		if ( isset($_POST['search']['value']) && $_POST['search']['value'] != "" ) {
  		   $sWhere = "WHERE (";
  			for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
  				$sWhere .= $aColumns[$i]." LIKE '%".addslashes( $_POST['search']['value'] )."%' OR ";
  			}
  			$sWhere = substr_replace( $sWhere, "", -3 );
  			$sWhere .= ')';
  		}

  		for ($i=0; $i < count($aColumns); $i++) {
  			if ( isset($_POST['columns'][$i]['search']['value']) && $_POST['columns'][$i]['search']['value'] != "" ) {
  				$searchCol = $_POST['columns'][$i]['search']['value'];
  				if ($searchCol != '') {
  					if ($sWhere != ''){
  						$sWhere .= " AND ". $aColumns[$i] . " LIKE '%" . $searchCol . "%' ";
  					} else {
  						$sWhere = "WHERE ". $aColumns[$i] . " LIKE '%" . $searchCol . "%' ";
  					}
  					 $sWhere .=  $cariOptional <> '' ?  $cariOptional . " AND " : '' ;

  				}
  			}
  		}




  		$top = (isset($_POST['start']))?((int)$_POST['start']):0 ;
  		$limit = (isset($_POST['length']))?((int)$_POST['length'] ):10 ;
  		$limit=$limit+$top;

  		$b =  $cariOptional <> '' ?   " AND ".$cariOptional  : '' ;
  		$sWhere = $sWhere.$b;

  		$rResult=$this->model_loc_bts->$qry_alldata($limit,$top,$sWhere);

  		$rResultCnt =$this->model_loc_bts->$qry_filtered($sWhere);
  		$iFilteredTotal = $rResultCnt['jml'];

  		$rResultTotal =$this->model_loc_bts->$qry_totalall();
  		$iTotal = $rResultTotal['jml'];

  		$output = array(
  			"draw"=> $_POST['draw'],
  			"recordsTotal" => $iTotal,
  			"recordsFiltered" => $iFilteredTotal,
  			"data" => array()
  		);
  		  $data['output']=$output;
  		  $data['rResult']=$rResult;

  		return $data;
  	}

function controler_griddialog(){
	$arcari=$this->globalsearch_dialog();
	$vResult=$this->initialize_grid("qry_alldatadialog","qry_filtereddialog","qry_totalalldialog",$arcari);
	$rResult=$vResult['rResult'];
	$output=$vResult['output'];

	foreach ($rResult as $aRow) {
        $row = array();
		$id=$aRow['unit_id'];
                $row[]=$aRow['unit_id'];
				$row[]=$aRow['unit_name'];
				$row[]=$aRow['unit_sqm'];
				$row[]=$aRow['lantai_name'];
                $row[]=$aRow['lantai_id'];

        if (!empty($row)) { $output['data'][] = $row; }
    	}
    	echo json_encode($output);

}

    function controler_gridpop(){
        $arcari=$this->globalsearch_rekanan();
        $vResult=$this->initialize_grid("qry_alldatapop","qry_filteredpop","qry_totalallpop",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['rekanan_id'];
                    $row[]=$aRow['rekanan_id'];
                    $row[]=$aRow['rekanan_name'];
                    $row[]=$aRow['rekananshipping_line'];
                    $row[]=$aRow['rekananshipping_name'];

            if (!empty($row)) { $output['data'][] = $row; }
            }
            echo json_encode($output);

    }

    function controler_gridschema(){
        $arcari=$this->globalsearch_schema();
        $vResult=$this->initialize_grid("qry_alldataschema","qry_filteredschema","qry_totalallschema",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['skl_id'];
                    $row[]=$aRow['skl_id'];
                    $row[]=$aRow['skl_title'];
                    $row[]=$aRow['skl_dp'];
                    $row[]=$aRow['skl_inst'];
                    $row[]=$aRow['skl_looterm'];
                    $row[]=$aRow['skl_loiterm'];
                    $row[]=$aRow['skl_rdep'];
                    $row[]=$aRow['skl_scdep'];
                    $row[]=$aRow['skl_islistrik'];
                    $row[]=$aRow['skl_isair'];
                    $row[]=$aRow['skl_isgas'];
                    $row[]=$aRow['skl_istelp'];
                    $row[]=$aRow['unittype_name'];

            if (!empty($row)) { $output['data'][] = $row; }
            }
            echo json_encode($output);

    }

    function controler_gridlookloo(){
        $arcari=$this->globalsearch_schema();
        $vResult=$this->initialize_grid("qry_alldatalook","qry_filteredlook","qry_totalalllook",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            
            $id=$aRow['loo_id'];
            $row[]=$aRow['loo_id'];
            $row[]=date("Y-m-d", strtotime($aRow['loo_date']));
            $row[]=$aRow['region_nameshort'];
            $row[]=$aRow['branch_name'];
            $row[]=$aRow['rekanan_name'];
            $row[]=$aRow['rekananshipping_name'];
            $row[]=$aRow['region_id'];
            $row[]=$aRow['branch_id'];
            $row[]=$aRow['rekanan_id'];
            $row[]=$aRow['rekananshipping_line'];
            $row[]=$aRow['unittype_id'];
            $row[]=date("Y-m-d", strtotime($aRow['loo_sdate']));
            $row[]=date("Y-m-d", strtotime($aRow['loo_edate']));
            $row[]=$aRow['loo_term'];
            $row[]=$aRow['loo_descr'];
            $row[]=$aRow['product_name'];
            $row[]=$aRow['fitting_out'];
            $row[]=$aRow['grace_period'];
            $row[]=$aRow['size_indoor'];
            $row[]=$aRow['size_outdoor'];
            $row[]=$aRow['debtor_no'];
            $row[]=$aRow['virtual_acc'];

            if (!empty($row)) { $output['data'][] = $row; }
            }   
            echo json_encode($output);
    }

    function controler_gridlist($val_search = ''){
		$arcari=$this->globalsearch_list();
		$searchStatus = $val_search;


		$criteria = null;
		if($searchStatus == 'app')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND CTE.isapproved = 1";
			}
			else
			{
				$criteria =  " CTE.isapproved = 1";
			}
		}
		elseif($searchStatus == 'ret')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND CTE.isconfirm = 1";
			}
			else
			{
				$criteria =  " CTE.isconfirm = 1";
			}
		}
		elseif($searchStatus == 'not_app')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND CTE.isapproved = 0";
			}
			else
			{
				$criteria =  " CTE.isapproved = 0";
			}
		}
		elseif($searchStatus == 'not_ret')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND CTE.isconfirm = 0";
			}
			else
			{
				$criteria =  " CTE.isconfirm = 0";
			}
		}
		elseif($searchStatus == 'all')
		{
			 $criteria = null ;
		}
		elseif($searchStatus == 'k')
		{
			 $criteria = null ;
		}

    	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari,$criteria);
    	$rResult=$vResult['rResult'];
    	$output=$vResult['output'];

    	foreach ($rResult as $aRow) {

            $i_link = str_replace('/', '_', $aRow['loc_id']);
            $ship_name = substr($aRow['rekanan_name'], 0, 15) . '...';
            $is_post = ($aRow['isconfirm']) ? 1 : 0;
            $is_post = ($aRow['isapproved']) ? 1 : 0;

            $row = array();

			         $row[]=$aRow['loc_id'];
               $row[]=date("d-m-Y", strtotime($aRow['loc_date']));
               $row[]=date("d-m-Y", strtotime($aRow['loc_sdate']));
               $row[]=date("d-m-Y", strtotime($aRow['loc_edate']));
			         $row[]=$aRow['loc_term'];
			         $row[]=$aRow['region_nameshort'];
			         $row[]=$aRow['branch_name'];
               $row[]=$ship_name;
               $row[]=$aRow['rekananshipping_name'];
               $row[]=$aRow['isapproved'];
               $row[]=$aRow['isconfirm'];
			         $row[]='
        <a href="/index.php/loc_bts/loc_bts/locedit/'.$i_link.'" data-toggle="tooltip" title="Edit">
          <i class="fa fa-edit fa-lg"></i></a>
        <a href="/index.php/locprint/locprintbts/locprintpdf/'.$i_link.'" data-toggle="tooltip" title="Print" target="_blank">
          <i class="fa fa-print fa-lg"></i></a>
        <a href="/index.php/loc_bts/loc_bts/loc_delete/'.$i_link.'" data-toggle="tooltip" title="Trash" onclick="return deleteid('.$is_post.')">
          <i class ="fa fa-trash fa-lg"></i></a>';

            if (!empty($row)) { $output['data'][] = $row; }
        	}
        	echo json_encode($output);

    }

    function loclist(){

        $loc_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_loc_bts->viewloc($loc_id),
                  'loc_id'   => $loc_id
            );


        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();

		    $this->breadcrumbcomponent->add('Loc BTS','loc_bts/loclist');

        $this->load->view('template/v_header');
        $this->load->view('loc_bts/loc_list', $data);
        $this->load->view('template/v_footer');
    }

    function locadd()
	{

        $loc_id = $this->uri->segment(4);

        $data   = array(
                  'result'    => $this->model_loc_bts->viewloc($loc_id),
                  'loc_id'   => $loc_id
            );

        $data['region']  = $this->region_select();
        $data['lotype'] = $this->loctype_select();
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();
        $data['unittype']   = $this->unittype_select();

  		$this->breadcrumbcomponent->add('Loc BTS','loc_bts/loc_bts/loclist')
            ->add('Input Loc','loc_bts/loc_bts/locadd');


        $this->load->view('template/v_header');
        $this->load->view('loc_bts/loc_add', $data);
        $this->load->view('template/v_footer');
	}


	function locedit(){

        $i_link = $this->uri->segment(4);

        $loc_id = str_replace('_', '/', $i_link);

        $data   = array(
                  'result'    => $this->model_loc_bts->viewloc($loc_id),
                  'loc_id'   => $loc_id
            );

        $data['region']     = $this->region_select();
        $data['lotype']     = $this->loctype_select();
        $data['agrtype']    = $this->agrtype_select();
        $data['titype']     = $this->titype_select();
        $data['unittype']   = $this->unittype_select();

        $data['resultd'] = $this->model_loc_bts->sholdetilby_id($loc_id);
        $data['resultu'] = $this->model_loc_bts->vdetilunitby_id($loc_id);

		$this->breadcrumbcomponent->add('Loc','loc_bts/loc_bts/loclist')
            ->add('Edit Loc','loc_bts/loc_bts/locedit');

        $this->load->view('template/v_header');
        $this->load->view('loc_bts/loc_edit', $data);
        $this->load->view('template/v_footer');
	}

    function locview(){

        $cont =  $this->uri->segment(4);
        $i_link = $this->uri->segment(5);

        $loc_id = str_replace('_', '/', $i_link);

        $data   = array(
                  'result'    => $this->model_loc_bts->viewloc($loc_id),
                  'loc_id'   => $loc_id
            );

        $data['region'] = $this->region_select();
        $data['lotype'] = $this->loctype_select();
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();

        $data['resultd'] = $this->model_loc_bts->sholdetilby_id($loc_id);
        $data['cont'] = $cont;

        switch ($cont){
            case "locconf":
                $crumb              = "Loc Return";
                $data['tabpost']    = " Return";
                break;

            case "locapp":
                $crumb              = "Loc Approval";
                $data['tabpost']    = " Approve";
                break;
            case "printcon":
                $crumb = "Print Confirmation";
                break;

        }

        $this->breadcrumbcomponent->add($crumb,'loc/'.$cont)
            ->add('View Loc','loc_bts/loc_bts/locview');

        $this->load->view('template/v_header');
        $this->load->view('loc_bts/loc_view', $data);
        $this->load->view('template/v_footer');
    }

	function locprint(){

        $i_link = $this->uri->segment(4);

        $loc_id = str_replace('_', '/', $i_link);

        $data   = array(
                  'result'    => $this->model_loc_bts->viewlocprint($loc_id),
                  'loc_id'   => $loc_id
            );

        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_loc_bts->sholdetilby_id($loc_id);

		$this->breadcrumbcomponent->add('Loc','loc_bts/loc_bts/loclist')
            ->add('Edit Loc','loc_bts/loc_bts/locedit');

        $this->load->view('loc_bts/rptloc', $data);
	}

    function region_select(){
        $this->load->model('template/Master_m');

        $region     = $this->Master_m->get_region();
        //$options    = array('' => 'Select an option');

        if(count($region)){
            foreach($region as $key => $value){
                $options[$value->region_id]= $value->region_name;
            }
        }

        return $options;
    }

    function shipping_select(){

        $rSearch = empty($_GET['id']) ? '' : $_GET['id'];
        //echo $rSearch;
        $this->load->model('template/Master_m');

        $agrtype      = $this->Master_m->get_shippingbyquery($rSearch);
        $options['data'][] = array(
                                'id'      => '',
                                'text'    => '',
                                'rekanan'    => ''
        );

        if(count($agrtype)){
            foreach($agrtype as $key => $value){


                    $options['data'][] = array(
                            'id'       => $value->rekananshipping_line,
                            'text'     => $value->rekananshipping_name,
                            'rekanan'  => $value->rekanan_id
                    );
            }
        }

        //return $options;
        echo json_encode($options);
    }

    function shipping_select2(){

        $rSearch = empty($_GET['term']) ? '' : $_GET['term'];



        if (is_array($rSearch) && $rSearch['_type'] == 'query'){

            $this->load->model('template/Master_m');

            $shipping      = $this->Master_m->get_shippingbyquery($rSearch['term']);

            $result['items']= $shipping;

            echo json_encode($result);

        };
    }

    function branch_select(){

        $rSearch = empty($_GET['term']) ? '' : $_GET['term'];
        $rRegion = empty($_GET['region']) ? '' : $_GET['region'];


        if (is_array($rSearch) && $rSearch['_type'] == 'query'){

            $this->load->model('template/Master_m');

            $branch      = $this->Master_m->get_branchbyquery($rSearch['term'], $rRegion);

            $result['items']= $branch;

            echo json_encode($result);

        };
    }

    function agrtype_select(){

        $this->load->model('template/Master_m');

        $agrtype      = $this->Master_m->get_agrtype();
        $options    = array('' => '==Pilih==');

        if(count($agrtype)){
            foreach($agrtype as $key => $value){
                $options[$value->agreementtype_id]= $value->agreementtype_name;
            }
        }

        return $options;
    }

    function agrtype_selecttype(){

        $lType = empty($_GET['loctype']) ? '' : $_GET['loctype'];
        $lType = trim($lType);

        $options  = array();

        $casual = array('RENTAL TEMP', 'SERVICE TEMP', 'UTILITIES', 'OTHER', 'PS', 'DEPOSIT');

        $permanent = array('RENTAL', 'RENTAL TEMP', 'SERVICE', 'OTHER', 'LOAN', 'DEPOSIT');

        $this->load->model('template/Master_m');

        $agrtype      = $this->Master_m->get_agrtypebytype($lType);
        $options['data'][] = array(
                                'id'      => '',
                                'text'    => '',
                                'type'    => ''
        );

        if(count($agrtype)){
            foreach($agrtype as $key => $value){

                if (in_array($value->agreementtype_type, $permanent, TRUE)){
                    $options['data'][] = array(
                            'id'       => $value->agreementtype_id,
                            'text'     => $value->agreementtype_name,
                            'type'     => 'PERMANENT'
                    );
                }

                if (in_array($value->agreementtype_type, $casual, TRUE)){
                    $options['data'][] = array(
                            'id'       => $value->agreementtype_id,
                            'text'     => $value->agreementtype_name,
                            'type'     => 'CASUAL'
                    );
                }
            }
        }

        echo json_encode($options);
    }


    function titype_select(){

        $options    = array('' => '==Pilih==');

        $options['0'] = 'Hari';
        $options['1'] = 'Bulan';
        $options['2'] = 'Tahun';

        return $options;
    }

    function unittype_select(){

        $this->load->model('template/Master_m');

        $unittype     = $this->Master_m->get_unittype();        

        if(count($unittype)){

            foreach($unittype as $key => $value){
              if($value->unittype_id == '07'){                

                $options[$value->unittype_id]= $value->unittype_name;
              }
            }
        }

        return $options;
    }

    function loctype_select(){

        $options    = array('' => '==Pilih==');

        $options['0'] = 'Permanent Leasing';
        $options['1'] = 'Casual Leasing';

        return $options;
    }

    function loc_add(){

        if ($_POST){

            $loc_id             = $this->input->post('loc_id');
            $loc_date           = $this->input->post('loc_date');
            $loc_sdate          = $this->input->post('loc_sdate');
            $loc_edate          = $this->input->post('loc_edate');
            $loc_term           = $this->input->post('loc_term');
            $loc_descr          = $this->input->post('loc_descr');
            $region             = $this->input->post('cboregion');
            $branch             = $this->input->post('cbobranch');
            $lease              = $this->input->post('cbolease');
            $tenant             = $this->input->post('htenant');
            $brand              = $this->input->post('hbrand');
            $_createby          = $this->input->post('_createby');
			      $_modifyby	        = $this->input->post('_modifyby');
			      $loc_line           = $this->input->post('tline');
            $loc_baserent       = $this->input->post('tcharge');
            $loc_space          = $this->input->post('tsize');
            $unit_id            = $this->input->post('tunit');
            $agrtype_id         = $this->input->post('tatype');
			      $lantai             = $this->input->post('tlantai');
            $int                    = $this->input->post('tint');
            $timetype               = $this->input->post('titype');
            $descr                  = $this->input->post('tdescr');
            $loc_percent            = $this->input->post('tval');
            $_ispercent             = $this->input->post('tper');
            $skl_id                 = $this->input->post('skl_id');
            $u_line                 = $this->input->post('uline');
            $u_unit                 = $this->input->post('uunit');
            $u_size                 = $this->input->post('usize');
            $u_lantai               = $this->input->post('ulantai');
            $u_rekananshipping_line = $this->input->post('ushipping');
            $u_sdate                = $this->input->post('usdate');
            $u_edate                = $this->input->post('uedate');
            $u_descr                = $this->input->post('udescr');
            $ref_id                 = $this->input->post('ref_id');
            $unittype_id            = $this->input->post('cbounittype');
            $u_region               = $this->input->post('cboregion');
            $u_branch               = $this->input->post('cbobranch');
            $u_tenant               = $this->input->post('htenant');
            $u_size2                = $this->input->post('usize2');
            $t_rekananshipping_line = $this->input->post('tshipping');
            $product_name           = $this->input->post('product_name');
            $fitting_out            = $this->input->post('fitting_out');
            $grace_period           = $this->input->post('grace_period');
            $size_indoor            = $this->input->post('size_indoor');
            $size_outdoor           = $this->input->post('size_outdoor');
            $u_virtual              = $this->input->post('uvirtual');

            $this->load->model('template/Master_m');
            $dtregion = $this->Master_m->get_regionbyid($region);

            $r_id = $dtregion[0]->region_nameshort;

        	$idx=$this->model_loc_bts->insertloc($loc_date, $loc_sdate, $loc_edate, $loc_term, $_createby, $_modifyby, $region, $branch,
                $lease, $loc_line,$unit_id,$agrtype_id,$loc_baserent, $r_id, $tenant, $brand, $int, $timetype, $loc_descr,
                $skl_id, $descr, $_ispercent, $loc_percent, $u_line, $u_unit, $u_size, $u_lantai, $u_rekananshipping_line,
                $u_sdate, $u_edate, $u_descr, $ref_id, $unittype_id, $u_region, $u_branch, $u_tenant, $u_size2, $t_rekananshipping_line,
                $product_name, $fitting_out, $grace_period, $size_indoor, $size_outdoor, $u_virtual);

        	redirect("loc_bts/loc_bts/loclist");
        }
    }

    function loc_edit(){

            $loc_id             = $this->input->post('loc_id');
            $loc_date           = $this->input->post('loc_date');
            $loc_descr          = $this->input->post('loc_descr');
            $loc_sdate          = $this->input->post('loc_sdate');
            $loc_edate          = $this->input->post('loc_edate');
            $loc_term           = $this->input->post('loc_term');
            $region             = $this->input->post('cboregion');
            $branch             = $this->input->post('cbobranch');
            $lease              = $this->input->post('cbolease');
            $tenant             = $this->input->post('htenant');
            $brand              = $this->input->post('hbrand');
            $_createby          = $this->input->post('_createby');
            $_modifyby          = $this->input->post('_modifyby');
            $loc_line           = $this->input->post('tline');
            $loc_baserent       = $this->input->post('tcharge');
            $unit_id            = $this->input->post('tunit');
            $agrtype_id         = $this->input->post('tatype');;
            $int                = $this->input->post('tint');
            $timetype           = $this->input->post('titype');
            $descr              = $this->input->post('tdescr');
            $loc_percent        = $this->input->post('tval');
            $_ispercent         = $this->input->post('tper');
            $u_line             = $this->input->post('uline');
            $u_unit             = $this->input->post('uunit');
            $u_size             = $this->input->post('usize');
            $u_lantai           = $this->input->post('ulantai');
            $u_rekananshipping_line           = $this->input->post('ushipping');
            $u_sdate           = $this->input->post('usdate');
            $u_edate           = $this->input->post('uedate');
            $u_descr          = $this->input->post('udescr');
            $ref_id          = $this->input->post('ref_id');
            $unittype_id          = $this->input->post('cbounittype');
            $u_region             = $this->input->post('cboregion');
            $u_branch             = $this->input->post('cbobranch');
            $u_tenant             = $this->input->post('htenant');
            $u_size2             = $this->input->post('usize2');
            $t_rekananshipping_line           = $this->input->post('tshipping');
            $product_name         = $this->input->post('product_name');
            $fitting_out         = $this->input->post('fitting_out');
            $grace_period         = $this->input->post('grace_period');
            $size_indoor         = $this->input->post('size_indoor');
            $size_outdoor         = $this->input->post('size_outdoor');
            $u_virtual              = $this->input->post('uvirtual');

		$this->model_loc_bts->updateloc($loc_id, $loc_date, $loc_descr, $loc_sdate, $loc_edate, $loc_term, $_createby, 
            $_modifyby, $region, $branch, $lease, $loc_line,$unit_id,$agrtype_id,$loc_baserent, $tenant, $brand, $int, 
            $timetype, $descr, $_ispercent, $loc_percent, $u_line, $u_unit, $u_size, $u_lantai, $u_rekananshipping_line, 
            $u_sdate, $u_edate, $u_descr, $ref_id, $unittype_id, $u_region, $u_branch, $u_tenant, $u_size2, 
            $t_rekananshipping_line, $product_name, $fitting_out, $grace_period, $size_indoor, $size_outdoor, $u_virtual);


		redirect("loc_bts/loc_bts/loclist");
    }

	function loc_delete(){

        $i_link = $this->uri->segment(4);

        $_id = str_replace('_', '/', $i_link);

		$this->model_loc_bts->deleteloc($_id);
		redirect("loc_bts/loc_bts/loclist");
	}

  function loc_getdetil(){
        
        $id = empty($_GET['id']) ? '' : $_GET['id'];

        $id = trim($id);

        if ($id == 'auto'){ $id = ''; }            
       
        $rResult = $this->model_loc_bts->get_detil($id);        

        foreach ($rResult as $aRow) {

            $row = array();            
            $row[]=$aRow['loo_id']; //0
            $row[]=$aRow['loodetil_line']; //1
            $row[]=$aRow['loodetil_int']; //2
            $row[]=$aRow['loodetil_descr']; //3
            $row[]=$aRow['loodetil_baserent']; //4
            $row[]=$aRow['loodetil_ispercent']; //5
            $row[]=$aRow['loodetil_percent']; //6
            $row[]=$aRow['loodetil_sdate']; //7
            $row[]=$aRow['loodetil_edate']; //8
            $row[]=$aRow['loodetil_term']; //9
            $row[]=$aRow['agreementtype_id']; //10
            $row[]=$aRow['unit_id']; //11
            $row[]=$aRow['timetype_id']; //12
            $row[]=$aRow['region_id']; //13
            $row[]=$aRow['branch_id']; //14
            $row[]=$aRow['rekanan_id']; //15
            $row[]=$aRow['rekananshipping_line']; //16
            $row[]=$aRow['agreementtype_name']; //17
            $row[]=$aRow['unit_name'];
            $row[]=$aRow['rekananshipping_name'];//19

        if (!empty($row)) { $output['data'][] = $row; }
        }   
        echo json_encode($output);
    }

    function loc_getunit(){
        
        $id = empty($_GET['id']) ? '' : $_GET['id'];

        $id = trim($id);

        if ($id == 'auto'){ $id = ''; }            
       
        $rResult = $this->model_loc_bts->get_unit($id);        

        foreach ($rResult as $aRow) {

            $row = array();            
            $row[]=$aRow['loo_id']; //0
            $row[]=$aRow['loounit_line']; //1
            $row[]=$aRow['loounit_space']; //2
            $row[]=$aRow['unit_id']; //3
            $row[]=$aRow['lantai_id']; //4
            $row[]=$aRow['region_id']; //5
            $row[]=$aRow['branch_id']; //6
            $row[]=$aRow['rekanan_id']; //7
            $row[]=$aRow['rekananshipping_line']; //8
            $row[]=$aRow['unit_name']; //9
            $row[]=$aRow['unit_sqm']; //10
            $row[]=$aRow['rekananshipping_name']; //11
            $row[]=$aRow['loounit_sdate']; //12
            $row[]=$aRow['loounit_edate']; //13
            $row[]=$aRow['loounit_size']; //14
            $row[]=$aRow['loounit_descr']; //15
            $row[]=$aRow['virtualaccount']; //15
            
        if (!empty($row)) { $output['data'][] = $row; }
        }   
        echo json_encode($output);
    }

    function locprintpdf(){
                $i_link = $this->uri->segment(4);
                $loc_id = str_replace('_', '/', $i_link);

                $vsc=$this->model_loc_bts->getservicecharge($loc_id);
                $vhargasc=$vsc['servicecharge'];

                $vpl=$this->model_loc_bts->getpromolevy($loc_id);
                $vpromolevy=$vpl['promolevy'];

                $dps=$this->model_loc_bts->getdepositr($loc_id);
                $vdps=$dps['depositr'];



        $data   = array(
                  'result'    => $this->model_loc_bts->viewlocprint($loc_id),
                  'loc_id'   => $loc_id,
                  'vunit'    => $this->model_loc_bts->getunitloc($loc_id),
                  'vhargasewa'    => $this->model_loc_bts->gethargasewa($loc_id),
                  'vhargasc' =>$vhargasc,
                  'vpromolevy' =>$vpromolevy,
                  'vdps' =>$vdps

               );

        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_loc_bts->sholdetilby_id($loc_id);

        $html=$this->load->view('loc/rptloc', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptloc.pdf";
        //$this->m_pdf->pdf->SetFont('zaskiagothic');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");


    }


    function printconpdf(){
                $i_link = $this->uri->segment(4);
                $loc_id = str_replace('_', '/', $i_link);

                $vsc=$this->model_loc_bts->getservicecharge($loc_id);
                $vhargasc=$vsc['servicecharge'];

                $vpl=$this->model_loc_bts->getpromolevy($loc_id);
                $vpromolevy=$vpl['promolevy'];

                $dps=$this->model_loc_bts->getdepositr($loc_id);
                $vdps=$dps['depositr'];
                $nildps=$dps['locdetil_baserent'];



        $data   = array(
                  'result'    => $this->model_loc_bts->viewconfprint($loc_id),
                  'loc_id'   => $loc_id,
                  'vunit'    => $this->model_loc_bts->getunitloc($loc_id),
                  'vhargasewa'    => $this->model_loc_bts->gethargasewa($loc_id),
                  'vhargasc' =>$vhargasc,
                  'vpromolevy' =>$vpromolevy,
                  'vdps' =>$vdps,
                  'nildps' =>$nildps

               );

        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_loc_bts->sholdetilby_id($loc_id);

        $html=$this->load->view('loc/rptconf', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptlocconf.pdf";
        //$this->m_pdf->pdf->SetFont('zaskiagothic');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");


    }

    function uploadjpg(){
        if($_POST) {

            $loc_id = $this->input->post('loc_id');
            $loc_id = str_replace('/', '_', $loc_id);


            if (is_image($_FILES['files']['tmp_name'])) {

                $allowed = array('jpg', 'jpeg', 'png');

                if(isset($_FILES['files']) && $_FILES['files']['error'] == 0){

                    $extension = pathinfo($_FILES['files']['name'], PATHINFO_EXTENSION);

                    if(!in_array(strtolower($extension), $allowed)){
                        echo '{"status":"error"}';
                        exit;
                    }

                    if(move_uploaded_file($_FILES['files']['tmp_name'], FCPATH.'/assets/uploads/'.$loc_id.'.'.$extension)){

                        //echo '{"status":"success"}';
                        $success = 1;
                    }
                }
            } else{
                $success = 0;
            }

        if ($success) {
            $result['files'][0] = array(
                'name'      => $loc_id.'.'.$extension,
                'size'      => 0,
                'url'       => base_url('/assets/uploads/'.$loc_id.'.'.$extension)
                );
        }else{
            $result['files'][0] = array(
                'error'     => 'Unknown format',
                'url'       => '',
                'size'      => 0
                );
        }

        echo json_encode($result);
        }
    }

}
