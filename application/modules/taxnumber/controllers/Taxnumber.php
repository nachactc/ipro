<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Taxnumber extends CI_Controller{

    function __construct(){

        parent::__construct();

        $this->load->model('model_taxnumber');
		$this->load->library('breadcrumbcomponent');
    }

    function index(){
        redirect('taxnumber/taxnumber/taxnumberlist');
    }
    function globalsearch_region(){
        $arcari=array('region_id','region_name');
        return $arcari;
    }

    function globalsearch_branch(){
        $arcari=array('A.branch_id','branch_name', 'region_id');
        return $arcari;
    }	
    function globalsearch_dialog(){
		$arcari=array('unit_name', 'region_id', 'branch_id');
		return $arcari;
	}
  function globalsearch_rekanan(){
        $arcari=array('rekanan_name','rekananshipping_name');
        return $arcari;
    }

    function globalsearch_list(){
  		$arcari=array('CTE.region_id','taxbranch_id','tax_status','tax_isdisable','Tax_no','Tax_no2','Tax_descr');
  		return $arcari;
  	}
    function globalsearch_schema(){
        $arcari=array('unittype_id');
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
					if ($aColumns[$i] == 'Tax_no') {
						if ($sWhere != ''){
							$sWhere .= " AND ". $aColumns[$i] . " BETWEEN '" . $searchCol . "' ";
						} else {
							$sWhere = "WHERE ". $aColumns[$i] . " BETWEEN '" . $searchCol . "' ";
						}
						 $sWhere .=  $cariOptional <> '' ?  $cariOptional . " AND " : '' ;												
					}
					elseif ($aColumns[$i] == 'Tax_no2') {
						if ($sWhere != ''){
							$sWhere .= " AND '". $searchCol . "' ";
						} else {
							$sWhere = "WHERE " . $searchCol . "' ";
						}
						 $sWhere .=  $cariOptional <> '' ?  $cariOptional . " AND " : '' ;												
					}					
					else
					{
						if ($sWhere != ''){
							$sWhere .= " AND ". $aColumns[$i] . " LIKE '%" . $searchCol . "%' ";
						} else {
							$sWhere = "WHERE ". $aColumns[$i] . " LIKE '%" . $searchCol . "%' ";
						}
						 $sWhere .=  $cariOptional <> '' ?  $cariOptional . " AND " : '' ;						
					}

  				}
  			}
  		}

		$sWhere = str_replace('Tax_no2', 'Tax_no', $sWhere);
		// echo 'bug : ' . $sWhere;
		// exit;

  		$top = (isset($_POST['start']))?((int)$_POST['start']):0 ;
  		$limit = (isset($_POST['length']))?((int)$_POST['length'] ):10 ;
  		$limit=$limit+$top;

  		$b =  $cariOptional <> '' ?   " AND ".$cariOptional  : '' ;
  		$sWhere = $sWhere.$b;

		$username=$this->session->userdata('username');
		//echo $username;
        //exit;
		$sWhereUser = "";
		if ($sWhere =='') {
			$sWhereUser = " where username = "."'".$username."'";
		}
        else
		{
			$sWhereUser = " and username = "."'".$username."'";
		}
		
  		$rResult=$this->model_taxnumber->$qry_alldata($limit,$top,$sWhere,$sWhereUser);

  		$rResultCnt =$this->model_taxnumber->$qry_filtered($sWhere,$sWhereUser);
  		$iFilteredTotal = $rResultCnt['jml'];

  		$rResultTotal =$this->model_taxnumber->$qry_totalall($sWhereUser);
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

    function controler_gridregion(){
        $arcari=$this->globalsearch_region();
        $vResult=$this->initialize_grid("qry_alldataregion","qry_filteredregion","qry_totalallregion",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['region_id'];
                    $row[]=$aRow['region_id'];
                    $row[]=$aRow['region_name'];

            if (!empty($row)) { $output['data'][] = $row; }
            }
            echo json_encode($output);

    }

    function controler_gridbranch(){
        $arcari=$this->globalsearch_branch();
        $vResult=$this->initialize_grid("qry_alldatabranch","qry_filteredbranch","qry_totalallbranch",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['branch_id'];
                    $row[]=$aRow['branch_id'];
                    $row[]=$aRow['branch_name'];

            if (!empty($row)) { $output['data'][] = $row; }
            }
            echo json_encode($output);

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
                    $row[]=$aRow['skl_taxnumberterm'];
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

    function controler_gridlist($val_search = ''){
		$arcari=$this->globalsearch_list();
		$searchStatus = $val_search;


		$criteria = null;
		if($searchStatus == '0')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND Tax_isdisable = 0";
			}
			else
			{
				$criteria =  " Tax_isdisable = 0";
			}
		}
		elseif($searchStatus == 'ret')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND Tax_isdisable = 1";
			}
			else
			{
				$criteria =  " Tax_isdisable = 0";
			}
		}


    	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari,$criteria);
    	$rResult=$vResult['rResult'];
    	$output=$vResult['output'];

    	foreach ($rResult as $aRow) {
           $i_link = str_replace('/', '_', $aRow['Tax_no']);
		   $i_link = str_replace('.', '_', $aRow['Tax_no']);
            $row = array();

			   $row[]=$aRow['region_id'];
               $row[]=$aRow['region_name'];
			   $row[]=$aRow['Tax_no'];
			   $row[]=$aRow['Tax_status'];
			   $row[]=$aRow['taxbranch_id'];
               $row[]=$aRow['branch_name'];
               $row[]=$aRow['Tax_descr'];
               $row[]=$aRow['Tax_isdisable'];
			         $row[]='
<a href="/index.php/taxnumber/taxnumber/taxnumberedit/'.$i_link.'" data-toggle="tooltip" class="btn btn-sm btn-success" title="Edit">
					<i class="glyphicon glyphicon-edit"></i>
                    </a>';
            if (!empty($row)) { $output['data'][] = $row; }
        	}
        	echo json_encode($output);

    }

    function taxnumberlist(){

        $taxnumber_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_taxnumber->viewtaxnumber($taxnumber_id),
                  'taxnumber_id'   => $taxnumber_id
            );


        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();

		$this->breadcrumbcomponent->add('TAX NUMBER','taxnumber/taxnumberlist');

        $this->load->view('template/v_header');
        $this->load->view('taxnumber/taxnumber_list', $data);
        $this->load->view('template/v_footer');
    }
	
	function taxnumberdisable(){

        $taxnumber_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_taxnumber->viewtaxnumber($taxnumber_id),
                  'taxnumber_id'   => $taxnumber_id
            );


        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();

		$this->breadcrumbcomponent->add('TAX NUMBER','taxnumber/taxnumberdisable');

        $this->load->view('template/v_header');
        $this->load->view('taxnumber/taxnumber_disable', $data);
        $this->load->view('template/v_footer');
    }

    function taxnumberadd()
	{

        $taxnumber_id = $this->uri->segment(4);

        $data   = array(
                  'result'    => $this->model_taxnumber->viewtaxnumber($taxnumber_id),
                  'taxnumber_id'   => $taxnumber_id
            );

        $data['region']  = $this->region_select();
        $data['lotype'] = $this->taxnumbertype_select();
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();
        $data['unittype']   = $this->unittype_select();

  		$this->breadcrumbcomponent->add('taxnumber','taxnumber/taxnumber/taxnumberlist')
            ->add('Input taxnumber','taxnumber/taxnumber/taxnumberadd');


        $this->load->view('template/v_header');
        $this->load->view('taxnumber/taxnumber_add', $data);
        $this->load->view('template/v_footer');
	}


	function taxnumberedit(){

        $i_link = $this->uri->segment(4);
		//echo $i_link;
        $taxnumber_id = str_replace('_', '/', $i_link);		
		$taxnumber_id = str_replace('_', '.', $i_link);		
        $data   = array(
                  'result'    => $this->model_taxnumber->viewtaxnumber($taxnumber_id),
                  'taxnumber_id'   => $taxnumber_id
            );

       // $data['region']     = $this->region_select();

       // $data['resultd'] = $this->model_taxnumber->sholdetilby_id($taxnumber_id);
        

		$this->breadcrumbcomponent->add('taxnumber','taxnumber/taxnumber/taxnumberlist')
            ->add('Edit Tax Number','taxnumber/taxnumber/taxnumberedit');

        $this->load->view('template/v_header');
        $this->load->view('taxnumber/taxnumber_edit', $data);
        $this->load->view('template/v_footer');
	}

    function taxnumberview(){

        $cont =  $this->uri->segment(4);
        $i_link = $this->uri->segment(5);

        $taxnumber_id = str_replace('_', '/', $i_link);

        $data   = array(
                  'result'    => $this->model_taxnumber->viewtaxnumber($taxnumber_id),
                  'taxnumber_id'   => $taxnumber_id
            );

        $data['region'] = $this->region_select();
        $data['lotype'] = $this->taxnumbertype_select();
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();

        $data['resultd'] = $this->model_taxnumber->sholdetilby_id($taxnumber_id);
        $data['cont'] = $cont;

        switch ($cont){
            case "taxnumberconf":
                $crumb              = "taxnumber Return";
                $data['tabpost']    = " Return";
                break;

            case "taxnumberapp":
                $crumb              = "taxnumber Approval";
                $data['tabpost']    = " Approve";
                break;
            case "printcon":
                $crumb = "Print Confirmation";
                break;

        }

        $this->breadcrumbcomponent->add($crumb,'taxnumber/'.$cont)
            ->add('View taxnumber','taxnumber/taxnumber/taxnumberview');

        $this->load->view('template/v_header');
        $this->load->view('taxnumber/taxnumber_view', $data);
        $this->load->view('template/v_footer');
    }

	function taxnumberprint(){

        $i_link = $this->uri->segment(4);

        $taxnumber_id = str_replace('_', '/', $i_link);

        $data   = array(
                  'result'    => $this->model_taxnumber->viewtaxnumberprint($taxnumber_id),
                  'taxnumber_id'   => $taxnumber_id
            );

        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_taxnumber->sholdetilby_id($taxnumber_id);

		$this->breadcrumbcomponent->add('taxnumber','taxnumber/taxnumber/taxnumberlist')
            ->add('Edit taxnumber','taxnumber/taxnumber/taxnumberedit');

        $this->load->view('taxnumber/rpttaxnumber', $data);
	}

    function region_select(){
        $this->load->model('template/Master_m');
		$username=$this->session->userdata('username');
        $region     = $this->model_taxnumber->get_region($username);
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
                            'rekanan'     => $value->rekanan_id
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
        //$rRegion = empty($_GET['region']) ? '' : $_GET['region'];

		
		
        if (is_array($rSearch) && $rSearch['_type'] == 'query'){

            $this->load->model('template/Master_m');

            $branch      = $this->Master_m->get_branchbyall($rSearch['term']);

            $result['items']= $branch;

            echo json_encode($result);

        };
    }

	    function taxbranch_select(){

        $rSearch = empty($_GET['term']) ? '' : $_GET['term'];
        //$rRegion = empty($_GET['region']) ? '' : $_GET['region'];

		$username=$this->session->userdata('username');
        if (is_array($rSearch) && $rSearch['_type'] == 'query'){

            $this->load->model('template/Master_m');

            $branch      = $this->model_taxnumber->get_branch($rSearch['term'],$username);

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

        $lType = empty($_GET['taxnumbertype']) ? '' : $_GET['taxnumbertype'];
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
                $options[$value->unittype_id]= $value->unittype_name;
            }
        }

        return $options;
    }

    function taxnumbertype_select(){

        $options    = array('' => '==Pilih==');

        $options['0'] = 'Permanent Leasing';
        $options['1'] = 'Casual Leasing';

        return $options;
    }

    function taxnumber_add(){

        if ($_POST){

            $tax_no             = $this->input->post('tserial');
            $region_id           = $this->input->post('tregion');
            $tax_status          = $this->input->post('tstatus');
            $tax_descr          = $this->input->post('tdescr');
            $tax_isdisable           = $this->input->post('tdisable');
            $taxbranch_id          = $this->input->post('tbranch');
			$username=$this->session->userdata('username');
          
			if ($taxbranch_id=='') {
				$taxbranch_id='0';
			}
			// echo $region_id;
			// echo $taxbranch_id;
			// exit;
			
        	$idx=$this->model_taxnumber->inserttaxnumber($tax_no, $region_id, $tax_status, $tax_descr, $tax_isdisable, $taxbranch_id,$username);

        	redirect("taxnumber/taxnumber/taxnumberlist");
        }
    }

    function taxnumber_edit(){

            $tax_no             = $this->input->post('tserial');
            $region_id           = $this->input->post('tregion');
            $tax_status          = $this->input->post('tstatus');
            $tax_descr          = $this->input->post('tdescr');
            $tax_isdisable           = $this->input->post('tdisable');
            $taxbranch_id          = $this->input->post('tbranch');
			$username=$this->session->userdata('username');
		//echo var_dump ($_POST);
		//exit;
		$this->model_taxnumber->updatetaxnumber($tax_no, $region_id, $tax_status, $tax_descr, $tax_isdisable, $taxbranch_id,$username);


		redirect("taxnumber/taxnumber/taxnumberlist");
    }

	function taxnumber_delete(){

        $i_link = $this->uri->segment(4);

        $_id = str_replace('_', '/', $i_link);

		$this->model_taxnumber->deletetaxnumber($_id);
		redirect("taxnumber/taxnumber/taxnumberlist");
	}

    function taxnumberprintpdf(){
                $i_link = $this->uri->segment(4);
                $taxnumber_id = str_replace('_', '/', $i_link);

                $vsc=$this->model_taxnumber->getservicecharge($taxnumber_id);
                $vhargasc=$vsc['servicecharge'];

                $vpl=$this->model_taxnumber->getpromolevy($taxnumber_id);
                $vpromolevy=$vpl['promolevy'];

                $dps=$this->model_taxnumber->getdepositr($taxnumber_id);
                $vdps=$dps['depositr'];



        $data   = array(
                  'result'    => $this->model_taxnumber->viewtaxnumberprint($taxnumber_id),
                  'taxnumber_id'   => $taxnumber_id,
                  'vunit'    => $this->model_taxnumber->getunittaxnumber($taxnumber_id),
                  'vhargasewa'    => $this->model_taxnumber->gethargasewa($taxnumber_id),
                  'vhargasc' =>$vhargasc,
                  'vpromolevy' =>$vpromolevy,
                  'vdps' =>$vdps

               );

        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_taxnumber->sholdetilby_id($taxnumber_id);

        $html=$this->load->view('taxnumber/rpttaxnumber', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rpttaxnumber.pdf";
        //$this->m_pdf->pdf->SetFont('zaskiagothic');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");


    }


    function printconpdf(){
                $i_link = $this->uri->segment(4);
                $taxnumber_id = str_replace('_', '/', $i_link);

                $vsc=$this->model_taxnumber->getservicecharge($taxnumber_id);
                $vhargasc=$vsc['servicecharge'];

                $vpl=$this->model_taxnumber->getpromolevy($taxnumber_id);
                $vpromolevy=$vpl['promolevy'];

                $dps=$this->model_taxnumber->getdepositr($taxnumber_id);
                $vdps=$dps['depositr'];
                $nildps=$dps['taxnumberdetil_baserent'];



        $data   = array(
                  'result'    => $this->model_taxnumber->viewconfprint($taxnumber_id),
                  'taxnumber_id'   => $taxnumber_id,
                  'vunit'    => $this->model_taxnumber->getunittaxnumber($taxnumber_id),
                  'vhargasewa'    => $this->model_taxnumber->gethargasewa($taxnumber_id),
                  'vhargasc' =>$vhargasc,
                  'vpromolevy' =>$vpromolevy,
                  'vdps' =>$vdps,
                  'nildps' =>$nildps

               );

        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_taxnumber->sholdetilby_id($taxnumber_id);

        $html=$this->load->view('taxnumber/rptconf', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rpttaxnumberconf.pdf";
        //$this->m_pdf->pdf->SetFont('zaskiagothic');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");


    }

    function uploadjpg(){
        if($_POST) {

            $taxnumber_id = $this->input->post('taxnumber_id');
            $taxnumber_id = str_replace('/', '_', $taxnumber_id);


            if (is_image($_FILES['files']['tmp_name'])) {

                $allowed = array('jpg', 'jpeg', 'png');

                if(isset($_FILES['files']) && $_FILES['files']['error'] == 0){

                    $extension = pathinfo($_FILES['files']['name'], PATHINFO_EXTENSION);

                    if(!in_array(strtolower($extension), $allowed)){
                        echo '{"status":"error"}';
                        exit;
                    }

                    if(move_uploaded_file($_FILES['files']['tmp_name'], FCPATH.'/assets/uploads/'.$taxnumber_id.'.'.$extension)){

                        //echo '{"status":"success"}';
                        $success = 1;
                    }
                }
            } else{
                $success = 0;
            }

        if ($success) {
            $result['files'][0] = array(
                'name'      => $taxnumber_id.'.'.$extension,
                'size'      => 0,
                'url'       => base_url('/assets/uploads/'.$taxnumber_id.'.'.$extension)
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
    function taxnumber_enable(){

        if ($_POST){

           $_APP = empty($_POST['postid']) ? '' : $_POST['postid'];
           //$password = empty($_POST['pwd']) ? '' : $_POST['pwd'];           
           
        }

        // Treat input as username
        //$type = 'username';

        //$username   = $this->session->userdata('username');  
        //$channel_id = $this->session->userdata('channel_id');             
		//print_r($_POST);
		//exit;
		
		$reason ='';
		
		if (is_array($_APP)){
			   if (count($_APP) >0){
				  foreach ($_APP as $key){     
					$region_id 	= $key[0];
					$tax_no   	= $key[2];
					$branch_id 	= $key[4];
					$disable   	= $key[8];
					
					$username          = $this->session->userdata('user_fullname');
					
					//echo $region_id;
					
					  
					  // $Criteria = ' isdisabled = 0 and branch_id = ' ."'"."'".$branch_id."'"."'";
					  // $Criteria2 = '';
					  
					  //echo $id;
					  //echo $line;
					  

						  //posting jurnal
						  
						  if($this->model_taxnumber->get_update_taxnumber_disable($region_id, $tax_no, $branch_id, $disable))
						  {	
								$result['success'] = TRUE;     
								$result['data'] = $tax_no;
								echo json_encode($result); 					  
						  }
						  else{							  
								$result['success'] = TRUE;     
								$result['data'] = $tax_no;
								echo json_encode($result);  
							}
													  						  
 
			   }
			   }
			 }
	 
        
    }
}
