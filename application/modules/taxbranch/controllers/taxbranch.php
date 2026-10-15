<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Taxbranch extends CI_Controller{

    function __construct(){

        parent::__construct();

        $this->load->model('model_taxbranch');
		$this->load->library('breadcrumbcomponent');
    }

    function index(){
        redirect('taxbranch/taxbranch/taxbranchlist');
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
  		$arcari=array('Tax_no',  'CTE.region_id','taxbranch_id','REGION.region_name','Tax_descr');
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

  		$rResult=$this->model_taxbranch->$qry_alldata($limit,$top,$sWhere);

  		$rResultCnt =$this->model_taxbranch->$qry_filtered($sWhere);
  		$iFilteredTotal = $rResultCnt['jml'];

  		$rResultTotal =$this->model_taxbranch->$qry_totalall();
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
                    $row[]=$aRow['skl_taxbranchterm'];
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
           $i_link = str_replace('/', '_', $aRow['taxbranch_id']);
            $row = array();
			$is_post =0;
			   $row[]=$aRow['region_id'];
               $row[]=$aRow['region_name'];
			   $row[]=$aRow['line'];
			   $row[]=$aRow['taxbranch_id'];
               $row[]=$aRow['branch_name'];
               $row[]=$aRow['taxbranch_descr'];
               $row[]=$aRow['isdisabled'];
			         $row[]='
				<a href="/index.php/taxbranch/taxbranch/taxbranchedit/'.$i_link.'" data-toggle="tooltip" title="Edit">
                <img border="0" src="'.base_url().'/assets/img/edit.png" width="21" height="21"></a>
				<a href="/index.php/taxbranch/taxbranch/taxbranch_delete/'.$i_link.'" data-toggle="tooltip" title="Trash"  onclick="return deleteid('.$is_post.')">
                <img border="0" src="'.base_url().'/assets/img/delete.png" width="21" height="21"></a>';
            if (!empty($row)) { $output['data'][] = $row; }
        	}
        	echo json_encode($output);

    }

    function taxbranchlist(){

        $taxbranch_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_taxbranch->viewtaxbranch($taxbranch_id),
                  'taxbranch_id'   => $taxbranch_id
            );


        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();

		$this->breadcrumbcomponent->add('TAX BRANCH','taxbranch/taxbranchlist');

        $this->load->view('template/v_header');
        $this->load->view('taxbranch/taxbranch_list', $data);
        $this->load->view('template/v_footer');
    }

    function taxbranchadd()
	{

        $taxbranch_id = $this->uri->segment(4);

        $data   = array(
                  'result'    => $this->model_taxbranch->viewtaxbranch($taxbranch_id),
                  'taxbranch_id'   => $taxbranch_id
            );

        $data['region']  = $this->region_select();
        $data['lotype'] = $this->taxbranchtype_select();
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();
        $data['unittype']   = $this->unittype_select();
		
  		$this->breadcrumbcomponent->add('taxbranch','taxbranch/taxbranch/taxbranchlist')
            ->add('Input Tax Branch','taxbranch/taxbranch/taxbranchadd');


        $this->load->view('template/v_header');
        $this->load->view('taxbranch/taxbranch_add', $data);
        $this->load->view('template/v_footer');
	}


	function taxbranchedit(){

        $i_link = $this->uri->segment(4);
		echo $i_link;
        $taxbranch_id = str_replace('_', '/', $i_link);		
        $data   = array(
                  'result'    => $this->model_taxbranch->viewtaxbranch($taxbranch_id),
                  'taxbranch_id'   => $taxbranch_id
            );

        $data['region']  = $this->region_select();
        $data['lotype'] = $this->taxbranchtype_select();
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();
        $data['unittype']   = $this->unittype_select();
        

		$this->breadcrumbcomponent->add('taxbranch','taxbranch/taxbranch/taxbranchlist')
            ->add('Edit Tax Branch','taxbranch/taxbranch/taxbranchedit');

        $this->load->view('template/v_header');
        $this->load->view('taxbranch/taxbranch_edit', $data);
        $this->load->view('template/v_footer');
	}

    function taxbranchview(){

        $cont =  $this->uri->segment(4);
        $i_link = $this->uri->segment(5);

        $taxbranch_id = str_replace('_', '/', $i_link);

        $data   = array(
                  'result'    => $this->model_taxbranch->viewtaxbranch($taxbranch_id),
                  'taxbranch_id'   => $taxbranch_id
            );

        $data['region'] = $this->region_select();
        $data['lotype'] = $this->taxbranchtype_select();
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();

        $data['resultd'] = $this->model_taxbranch->sholdetilby_id($taxbranch_id);
        $data['cont'] = $cont;

        switch ($cont){
            case "taxbranchconf":
                $crumb              = "taxbranch Return";
                $data['tabpost']    = " Return";
                break;

            case "taxbranchapp":
                $crumb              = "taxbranch Approval";
                $data['tabpost']    = " Approve";
                break;
            case "printcon":
                $crumb = "Print Confirmation";
                break;

        }

        $this->breadcrumbcomponent->add($crumb,'taxbranch/'.$cont)
            ->add('View taxbranch','taxbranch/taxbranch/taxbranchview');

        $this->load->view('template/v_header');
        $this->load->view('taxbranch/taxbranch_view', $data);
        $this->load->view('template/v_footer');
    }

	function taxbranchprint(){

        $i_link = $this->uri->segment(4);

        $taxbranch_id = str_replace('_', '/', $i_link);

        $data   = array(
                  'result'    => $this->model_taxbranch->viewtaxbranchprint($taxbranch_id),
                  'taxbranch_id'   => $taxbranch_id
            );

        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_taxbranch->sholdetilby_id($taxbranch_id);

		$this->breadcrumbcomponent->add('taxbranch','taxbranch/taxbranch/taxbranchlist')
            ->add('Edit taxbranch','taxbranch/taxbranch/taxbranchedit');

        $this->load->view('taxbranch/rpttaxbranch', $data);
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

        $lType = empty($_GET['taxbranchtype']) ? '' : $_GET['taxbranchtype'];
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

    function taxbranchtype_select(){

        $options    = array('' => '==Pilih==');

        $options['0'] = 'Permanent Leasing';
        $options['1'] = 'Casual Leasing';

        return $options;
    }

    function taxbranch_add(){

        if ($_POST){

            $taxbranch_id          = $this->input->post('ibranch');
			$branch_id          = $this->input->post('ibranch');
          
			$branchname          = $this->model_taxbranch->getbranchname($branch_id );
			$branch_name=$branchname['branch_name'];
			
        	$idx=$this->model_taxbranch->inserttaxbranch($taxbranch_id, $branch_id, $branch_name);

        	redirect("taxbranch/taxbranch/taxbranchlist");
        }
    }

    function taxbranch_edit(){
		if ($_POST){
            $taxbranch_id             = $this->input->post('ibranchid');
            $cisdisabled           = $this->input->post('isdisabled');
			
		//echo ($taxbranch_id);
		//exit;
		
		if ($cisdisabled == 'on'){
		  $isdisabled ='1';
		}		
		else
		{
			$isdisabled ='0';
		}
		$this->model_taxbranch->updatetaxbranch($taxbranch_id, $isdisabled);


		redirect("taxbranch/taxbranch/taxbranchlist");
		}
    }

	function taxbranch_delete(){

        $i_link = $this->uri->segment(4);

        $_id = str_replace('_', '/', $i_link);

		$this->model_taxbranch->deletetaxbranch($_id);
		redirect("taxbranch/taxbranch/taxbranchlist");
	}

    function taxbranchprintpdf(){
                $i_link = $this->uri->segment(4);
                $taxbranch_id = str_replace('_', '/', $i_link);

                $vsc=$this->model_taxbranch->getservicecharge($taxbranch_id);
                $vhargasc=$vsc['servicecharge'];

                $vpl=$this->model_taxbranch->getpromolevy($taxbranch_id);
                $vpromolevy=$vpl['promolevy'];

                $dps=$this->model_taxbranch->getdepositr($taxbranch_id);
                $vdps=$dps['depositr'];



        $data   = array(
                  'result'    => $this->model_taxbranch->viewtaxbranchprint($taxbranch_id),
                  'taxbranch_id'   => $taxbranch_id,
                  'vunit'    => $this->model_taxbranch->getunittaxbranch($taxbranch_id),
                  'vhargasewa'    => $this->model_taxbranch->gethargasewa($taxbranch_id),
                  'vhargasc' =>$vhargasc,
                  'vpromolevy' =>$vpromolevy,
                  'vdps' =>$vdps

               );

        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_taxbranch->sholdetilby_id($taxbranch_id);

        $html=$this->load->view('taxbranch/rpttaxbranch', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rpttaxbranch.pdf";
        //$this->m_pdf->pdf->SetFont('zaskiagothic');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");


    }


    function printconpdf(){
                $i_link = $this->uri->segment(4);
                $taxbranch_id = str_replace('_', '/', $i_link);

                $vsc=$this->model_taxbranch->getservicecharge($taxbranch_id);
                $vhargasc=$vsc['servicecharge'];

                $vpl=$this->model_taxbranch->getpromolevy($taxbranch_id);
                $vpromolevy=$vpl['promolevy'];

                $dps=$this->model_taxbranch->getdepositr($taxbranch_id);
                $vdps=$dps['depositr'];
                $nildps=$dps['taxbranchdetil_baserent'];



        $data   = array(
                  'result'    => $this->model_taxbranch->viewconfprint($taxbranch_id),
                  'taxbranch_id'   => $taxbranch_id,
                  'vunit'    => $this->model_taxbranch->getunittaxbranch($taxbranch_id),
                  'vhargasewa'    => $this->model_taxbranch->gethargasewa($taxbranch_id),
                  'vhargasc' =>$vhargasc,
                  'vpromolevy' =>$vpromolevy,
                  'vdps' =>$vdps,
                  'nildps' =>$nildps

               );

        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_taxbranch->sholdetilby_id($taxbranch_id);

        $html=$this->load->view('taxbranch/rptconf', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rpttaxbranchconf.pdf";
        //$this->m_pdf->pdf->SetFont('zaskiagothic');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");


    }

    function uploadjpg(){
        if($_POST) {

            $taxbranch_id = $this->input->post('taxbranch_id');
            $taxbranch_id = str_replace('/', '_', $taxbranch_id);


            if (is_image($_FILES['files']['tmp_name'])) {

                $allowed = array('jpg', 'jpeg', 'png');

                if(isset($_FILES['files']) && $_FILES['files']['error'] == 0){

                    $extension = pathinfo($_FILES['files']['name'], PATHINFO_EXTENSION);

                    if(!in_array(strtolower($extension), $allowed)){
                        echo '{"status":"error"}';
                        exit;
                    }

                    if(move_uploaded_file($_FILES['files']['tmp_name'], FCPATH.'/assets/uploads/'.$taxbranch_id.'.'.$extension)){

                        //echo '{"status":"success"}';
                        $success = 1;
                    }
                }
            } else{
                $success = 0;
            }

        if ($success) {
            $result['files'][0] = array(
                'name'      => $taxbranch_id.'.'.$extension,
                'size'      => 0,
                'url'       => base_url('/assets/uploads/'.$taxbranch_id.'.'.$extension)
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
