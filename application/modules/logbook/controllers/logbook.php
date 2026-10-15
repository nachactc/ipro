<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class logbook extends CI_Controller{

    function __construct(){

        parent::__construct();

        $this->load->model('model_logbook');
		$this->load->library('breadcrumbcomponent');
    }

    function index(){
        redirect('logbook/logbook/logbooklist');
    }
    function globalsearch_dialog(){
		$arcari=array('unit_name', 'region_id', 'branch_id');
		return $arcari;
	}

    function globalsearch_list(){
  		$arcari=array('CTE.region_id','CTE.branch_id','CTE.rekanan_id','CTE.rekananshipping_line');
  		return $arcari;
  	}
    function globalsearch_schema(){
        $arcari=array('unittype_id');
        return $arcari;
    }
    function globalsearch_region(){
        $arcari=array('region_id','region_name');
        return $arcari;
    }

    function globalsearch_branch(){
        $arcari=array('A.branch_id','branch_name', 'region_id');
        return $arcari;
    }
	
    function globalsearch_rekanan(){
        $arcari=array('rekanan_name','A.rekanan_id', 'branch_id');
        return $arcari;
    }
    function globalsearch_brand(){
        $arcari=array('rekananshipping_line','rekananshipping_name','rekanan_id');
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


		// echo 'bug : ' . $sWhere;
		// exit;

  		$top = (isset($_POST['start']))?((int)$_POST['start']):0 ;
  		$limit = (isset($_POST['length']))?((int)$_POST['length'] ):10 ;
  		$limit=$limit+$top;

  		$b =  $cariOptional <> '' ?   " AND ".$cariOptional  : '' ;
  		$sWhere = $sWhere.$b;


  		$rResult=$this->model_logbook->$qry_alldata($limit,$top,$sWhere);

  		$rResultCnt =$this->model_logbook->$qry_filtered($sWhere);
  		$iFilteredTotal = $rResultCnt['jml'];

  		$rResultTotal =$this->model_logbook->$qry_totalall();
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
                    $row[]=$aRow['skl_logbookterm'];
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
		 


    	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari,$criteria);
    	$rResult=$vResult['rResult'];
    	$output=$vResult['output'];

    	foreach ($rResult as $aRow) {
           $i_link = str_replace('/', '_', $aRow['logbook_id']);
		   $i_link = str_replace('.', '_', $aRow['logbook_id']);
		   $is_post = 0;
            $row = array();

			   $row[]=$aRow['logbook_id'];
               $row[]=$aRow['region_name'];
               $row[]=$aRow['branch_name'];
               $row[]=$aRow['rekanan_name'];
               $row[]=$aRow['rekananshipping_name'];
               $row[]=$aRow['rowid'];
               $row[]=$aRow['telp_date'];
               $row[]=$aRow['telp_no'];
               $row[]=$aRow['result'];
			   $row[]=$aRow['create_by'];
               $row[]=$aRow['create_date'];
			         $row[]='
					<a href="/index.php/logbook/logbook/logbook_delete/'.$i_link.'" data-toggle="tooltip" title="Trash" onclick="return deleteid('.$is_post.')">
                    <img border="0" src="'.base_url().'/assets/img/delete.png" width="21" height="21"></a>';
            if (!empty($row)) { $output['data'][] = $row; }
        	}
        	echo json_encode($output);

    }
    function controler_gridtenant(){
        $arcari=$this->globalsearch_rekanan();
        $vResult=$this->initialize_grid("qry_alldatatenant","qry_filteredtenant","qry_totalalltenant",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['rekanan_id'];
                    $row[]=$aRow['rekanan_id'];
                    $row[]=$aRow['rekanan_name'];

            if (!empty($row)) { $output['data'][] = $row; }
            }
            echo json_encode($output);

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

    function controler_gridbrand(){
        $arcari=$this->globalsearch_brand();
        $vResult=$this->initialize_grid("qry_alldatabrand","qry_filteredbrand","qry_totalallbrand",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['rekananshipping_line'];
                    $row[]=$aRow['rekananshipping_line'];
                    $row[]=$aRow['rekananshipping_name'];
					$row[]=$aRow['rowid'];

            if (!empty($row)) { $output['data'][] = $row; }
            }
            echo json_encode($output);

    }
	
    function logbooklist(){

        $logbook_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_logbook->viewlogbook($logbook_id),
                  'logbook_id'   => $logbook_id
            );


        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();

		$this->breadcrumbcomponent->add('TAX NUMBER','logbook/logbooklist');

        $this->load->view('template/v_header');
        $this->load->view('logbook/logbook_list', $data);
        $this->load->view('template/v_footer');
    }

    function logbookadd()
	{

        $logbook_id = $this->uri->segment(4);

        $data   = array(
                  'result'    => $this->model_logbook->viewlogbook($logbook_id),
                  'logbook_id'   => $logbook_id
            );

        $data['region']  = $this->region_select();
        $data['lotype'] = $this->logbooktype_select();
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();
        $data['unittype']   = $this->unittype_select();

  		$this->breadcrumbcomponent->add('logbook','logbook/logbook/logbooklist')
            ->add('Input logbook','logbook/logbook/logbookadd');


        $this->load->view('template/v_header');
        $this->load->view('logbook/logbook_add', $data);
        $this->load->view('template/v_footer');
	}


	function logbookedit(){

        $i_link = $this->uri->segment(4);
		//echo $i_link;
        $logbook_id = str_replace('_', '/', $i_link);		
		$logbook_id = str_replace('_', '.', $i_link);		
        $data   = array(
                  'result'    => $this->model_logbook->viewlogbook($logbook_id),
                  'logbook_id'   => $logbook_id
            );

       // $data['region']     = $this->region_select();

       // $data['resultd'] = $this->model_logbook->sholdetilby_id($logbook_id);
        

		$this->breadcrumbcomponent->add('logbook','logbook/logbook/logbooklist')
            ->add('Edit Tax Number','logbook/logbook/logbookedit');

        $this->load->view('template/v_header');
        $this->load->view('logbook/logbook_edit', $data);
        $this->load->view('template/v_footer');
	}

    function logbookview(){

        $cont =  $this->uri->segment(4);
        $i_link = $this->uri->segment(5);

        $logbook_id = str_replace('_', '/', $i_link);

        $data   = array(
                  'result'    => $this->model_logbook->viewlogbook($logbook_id),
                  'logbook_id'   => $logbook_id
            );

        $data['region'] = $this->region_select();
        $data['lotype'] = $this->logbooktype_select();
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();

        $data['resultd'] = $this->model_logbook->sholdetilby_id($logbook_id);
        $data['cont'] = $cont;

        switch ($cont){
            case "logbookconf":
                $crumb              = "logbook Return";
                $data['tabpost']    = " Return";
                break;

            case "logbookapp":
                $crumb              = "logbook Approval";
                $data['tabpost']    = " Approve";
                break;
            case "printcon":
                $crumb = "Print Confirmation";
                break;

        }

        $this->breadcrumbcomponent->add($crumb,'logbook/'.$cont)
            ->add('View logbook','logbook/logbook/logbookview');

        $this->load->view('template/v_header');
        $this->load->view('logbook/logbook_view', $data);
        $this->load->view('template/v_footer');
    }

	function logbookprint(){

        $i_link = $this->uri->segment(4);

        $logbook_id = str_replace('_', '/', $i_link);

        $data   = array(
                  'result'    => $this->model_logbook->viewlogbookprint($logbook_id),
                  'logbook_id'   => $logbook_id
            );

        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_logbook->sholdetilby_id($logbook_id);

		$this->breadcrumbcomponent->add('logbook','logbook/logbook/logbooklist')
            ->add('Edit logbook','logbook/logbook/logbookedit');

        $this->load->view('logbook/rptlogbook', $data);
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


        if (is_array($rSearch) && $rSearch['_type'] == 'query'){

            $this->load->model('template/Master_m');

            $branch      = $this->Master_m->get_taxbranch($rSearch['term']);

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

        $lType = empty($_GET['logbooktype']) ? '' : $_GET['logbooktype'];
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

    function logbooktype_select(){

        $options    = array('' => '==Pilih==');

        $options['0'] = 'Permanent Leasing';
        $options['1'] = 'Casual Leasing';

        return $options;
    }

    function logbook_add(){

        if ($_POST){

            $region_id           = $this->input->post('hregion');
			$branch_id           = $this->input->post('hbranch');
			$rekanan_id           = $this->input->post('htenant');
            $rekananshipping_line          = $this->input->post('hbrand');
            $telpno          = $this->input->post('itelpno');
            $telpdate           = $this->input->post('itelpdate');
            $result          = $this->input->post('iresult');
			$debtor          = $this->input->post('idebtor');
			$user_name =   $this->session->userdata('user_fullname');

        	$idx=$this->model_logbook->insertlogbook($region_id, $branch_id, $rekanan_id, $rekananshipping_line, $debtor, $telpno, $telpdate, $result, $user_name);

        	redirect("logbook/logbook/logbooklist");
        }
    }

    function logbook_edit(){

            $tax_no             = $this->input->post('tserial');
            $region_id           = $this->input->post('tregion');
            $tax_status          = $this->input->post('tstatus');
            $tax_descr          = $this->input->post('tdescr');
            $tax_isdisable           = $this->input->post('tdisable');
            $taxbranch_id          = $this->input->post('tbranch');
		//echo var_dump ($_POST);
		//exit;
		$this->model_logbook->updatelogbook($tax_no, $region_id, $tax_status, $tax_descr, $tax_isdisable, $taxbranch_id);


		redirect("logbook/logbook/logbooklist");
    }

	function logbook_delete(){

        $i_link = $this->uri->segment(4);

        $_id = str_replace('_', '/', $i_link);

		$this->model_logbook->deletelogbook($_id);
		redirect("logbook/logbook/logbooklist");
	}

    function logbookprintpdf(){
                $i_link = $this->uri->segment(4);
                $logbook_id = str_replace('_', '/', $i_link);

                $vsc=$this->model_logbook->getservicecharge($logbook_id);
                $vhargasc=$vsc['servicecharge'];

                $vpl=$this->model_logbook->getpromolevy($logbook_id);
                $vpromolevy=$vpl['promolevy'];

                $dps=$this->model_logbook->getdepositr($logbook_id);
                $vdps=$dps['depositr'];



        $data   = array(
                  'result'    => $this->model_logbook->viewlogbookprint($logbook_id),
                  'logbook_id'   => $logbook_id,
                  'vunit'    => $this->model_logbook->getunitlogbook($logbook_id),
                  'vhargasewa'    => $this->model_logbook->gethargasewa($logbook_id),
                  'vhargasc' =>$vhargasc,
                  'vpromolevy' =>$vpromolevy,
                  'vdps' =>$vdps

               );

        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_logbook->sholdetilby_id($logbook_id);

        $html=$this->load->view('logbook/rptlogbook', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptlogbook.pdf";
        //$this->m_pdf->pdf->SetFont('zaskiagothic');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");


    }


    function printconpdf(){
                $i_link = $this->uri->segment(4);
                $logbook_id = str_replace('_', '/', $i_link);

                $vsc=$this->model_logbook->getservicecharge($logbook_id);
                $vhargasc=$vsc['servicecharge'];

                $vpl=$this->model_logbook->getpromolevy($logbook_id);
                $vpromolevy=$vpl['promolevy'];

                $dps=$this->model_logbook->getdepositr($logbook_id);
                $vdps=$dps['depositr'];
                $nildps=$dps['logbookdetil_baserent'];



        $data   = array(
                  'result'    => $this->model_logbook->viewconfprint($logbook_id),
                  'logbook_id'   => $logbook_id,
                  'vunit'    => $this->model_logbook->getunitlogbook($logbook_id),
                  'vhargasewa'    => $this->model_logbook->gethargasewa($logbook_id),
                  'vhargasc' =>$vhargasc,
                  'vpromolevy' =>$vpromolevy,
                  'vdps' =>$vdps,
                  'nildps' =>$nildps

               );

        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_logbook->sholdetilby_id($logbook_id);

        $html=$this->load->view('logbook/rptconf', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptlogbookconf.pdf";
        //$this->m_pdf->pdf->SetFont('zaskiagothic');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");


    }

    function uploadjpg(){
        if($_POST) {

            $logbook_id = $this->input->post('logbook_id');
            $logbook_id = str_replace('/', '_', $logbook_id);


            if (is_image($_FILES['files']['tmp_name'])) {

                $allowed = array('jpg', 'jpeg', 'png');

                if(isset($_FILES['files']) && $_FILES['files']['error'] == 0){

                    $extension = pathinfo($_FILES['files']['name'], PATHINFO_EXTENSION);

                    if(!in_array(strtolower($extension), $allowed)){
                        echo '{"status":"error"}';
                        exit;
                    }

                    if(move_uploaded_file($_FILES['files']['tmp_name'], FCPATH.'/assets/uploads/'.$logbook_id.'.'.$extension)){

                        //echo '{"status":"success"}';
                        $success = 1;
                    }
                }
            } else{
                $success = 0;
            }

        if ($success) {
            $result['files'][0] = array(
                'name'      => $logbook_id.'.'.$extension,
                'size'      => 0,
                'url'       => base_url('/assets/uploads/'.$logbook_id.'.'.$extension)
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
