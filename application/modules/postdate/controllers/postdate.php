<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Postdate extends CI_Controller{

    function __construct(){

        parent::__construct();

        $this->load->model('model_postdate');
		$this->load->library('breadcrumbcomponent');
    }

    function index(){
        redirect('postdate/postdate/postdatelist');
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
  		$arcari=array('periode','agreement_type','posting_date');
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

  		$rResult=$this->model_postdate->$qry_alldata($limit,$top,$sWhere);

  		$rResultCnt =$this->model_postdate->$qry_filtered($sWhere);
  		$iFilteredTotal = $rResultCnt['jml'];

  		$rResultTotal =$this->model_postdate->$qry_totalall();
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
                    $row[]=$aRow['skl_postdateterm'];
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
           $i_link = date('Y-m-d', strtotime($aRow['posting_date']));
		   $periode =$aRow['periode'];
		   $type =$aRow['agreement_type'];
		   $link = $i_link . '/'. $periode . '/'. $type;
		   $blank ='';
            $row = array();
			$is_post =0;
			   $row[]=$aRow['periode'];
			   $row[]=date('Y-m-d', strtotime($aRow['posting_date']));
			   $row[]=date('Y-m-d', strtotime($aRow['due_date']));
			   $row[]=$aRow['agreement_type'];
               $row[]=$aRow['descr'];
               $row[]=$aRow['isdisable'];			   
			   $row[]=$blank;
			   $row[]=$blank;
			   $row[]=$blank;
			   $row[]=$blank;
			   $row[]=$blank;
			   $row[]=$blank;
			   $row[]=$blank;
			   $row[]=$blank;
			   $row[]=$blank;
			   $row[]=$blank;
			         $row[]='
				<a href="/index.php/postdate/postdate/postdateedit/'.$link.'" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-info">
                 EDIT</a>
				<a href="/index.php/postdate/postdate/postdate_delete/'.$link.'" data-toggle="tooltip" title="Trash"  class="btn btn-sm btn-danger" onclick="return deleteid('.$is_post.')">
                DELETE</a>';
            if (!empty($row)) { $output['data'][] = $row; }
        	}
        	echo json_encode($output);

    }

    function postdatelist(){

        $postdate_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_postdate->viewpostdateALL($postdate_id),
                  'postdate_id'   => $postdate_id
            );


        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();

		$this->breadcrumbcomponent->add('POSTING DATE','postdate/postdatelist');

        $this->load->view('template/v_header');
        $this->load->view('postdate/postdate_list', $data);
        $this->load->view('template/v_footer');
    }

    function postdateadd()
	{

        $postdate_id = $this->uri->segment(4);
		$timestamp = time();
        $posting_date = date("Y-m-d H:i:s", $timestamp);
        $data   = array(
                  'result'    => $this->model_postdate->viewpostdateALL($posting_date),
                  'posting_date'   => $posting_date
            );

        // $data['region']  = $this->region_select();
        // $data['lotype'] = $this->postdatetype_select();
        // $data['agrtype'] = $this->agrtype_select();
        // $data['titype'] = $this->titype_select();
        // $data['unittype']   = $this->unittype_select();
		$data['agrtype'] = $this->agrtype_select();
		
  		$this->breadcrumbcomponent->add('postdate','postdate/postdate/postdatelist')
            ->add('Input Posting Date','postdate/postdate/postdateadd');


        $this->load->view('template/v_header');
        $this->load->view('postdate/postdate_add', $data);
        $this->load->view('template/v_footer');
	}


	function postdateedit(){

        $i_link = $this->uri->segment(4);
		$periode = $this->uri->segment(5);
		$type = $this->uri->segment(6);
		// echo $type;
		// exit;
        $posting_date = str_replace('_', '/', $i_link);		
        $data   = array(
                  'result'    => $this->model_postdate->viewpostdate($posting_date,$periode,$type),
                  'posting_date'   => $posting_date
            );

        // $data['region']  = $this->region_select();
        // $data['lotype'] = $this->postdatetype_select();
        $data['agrtype'] = $this->agrtype_select();
        // $data['titype'] = $this->titype_select();
        // $data['unittype']   = $this->unittype_select();
        

		$this->breadcrumbcomponent->add('postdate','postdate/postdate/postdatelist')
            ->add('Edit Posting Date','postdate/postdate/postdateedit');

		// print_r($data);
		// exit;
        $this->load->view('template/v_header');
        $this->load->view('postdate/postdate_edit', $data);
        $this->load->view('template/v_footer');
	}

    function postdateview(){

        $cont =  $this->uri->segment(4);
        $i_link = $this->uri->segment(5);

        $postdate_id = str_replace('_', '/', $i_link);

        $data   = array(
                  'result'    => $this->model_postdate->viewpostdate($postdate_id),
                  'postdate_id'   => $postdate_id
            );

        $data['region'] = $this->region_select();
        $data['lotype'] = $this->postdatetype_select();
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();

        $data['resultd'] = $this->model_postdate->sholdetilby_id($postdate_id);
        $data['cont'] = $cont;

        switch ($cont){
            case "postdateconf":
                $crumb              = "postdate Return";
                $data['tabpost']    = " Return";
                break;

            case "postdateapp":
                $crumb              = "postdate Approval";
                $data['tabpost']    = " Approve";
                break;
            case "printcon":
                $crumb = "Print Confirmation";
                break;

        }

        $this->breadcrumbcomponent->add($crumb,'postdate/'.$cont)
            ->add('View postdate','postdate/postdate/postdateview');

        $this->load->view('template/v_header');
        $this->load->view('postdate/postdate_view', $data);
        $this->load->view('template/v_footer');
    }

	function postdateprint(){

        $i_link = $this->uri->segment(4);

        $postdate_id = str_replace('_', '/', $i_link);

        $data   = array(
                  'result'    => $this->model_postdate->viewpostdateprint($postdate_id),
                  'postdate_id'   => $postdate_id
            );

        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_postdate->sholdetilby_id($postdate_id);

		$this->breadcrumbcomponent->add('postdate','postdate/postdate/postdatelist')
            ->add('Edit postdate','postdate/postdate/postdateedit');

        $this->load->view('postdate/rptpostdate', $data);
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

	    function postdate_select(){

        $rSearch = empty($_GET['term']) ? '' : $_GET['term'];
        //$rRegion = empty($_GET['region']) ? '' : $_GET['region'];


        if (is_array($rSearch) && $rSearch['_type'] == 'query'){

            $this->load->model('template/Master_m');

            $branch      = $this->Master_m->get_postdate($rSearch['term']);

            $result['items']= $branch;

            echo json_encode($result);

        };
    }
    function agrtype_select2(){

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

        $lType = empty($_GET['postdatetype']) ? '' : $_GET['postdatetype'];
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


    function agrtype_select(){

        $options    = array('' => '==Pilih==');

        $options['general'] = 'General';
        $options['utilities'] = 'Utilities';

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

    function postdatetype_select(){

        $options    = array('' => '==Pilih==');

        $options['0'] = 'Permanent Leasing';
        $options['1'] = 'Casual Leasing';

        return $options;
    }

    function postdate_add(){

        if ($_POST){

			$periode             = $this->input->post('iperiode');
            $posting_date             = $this->input->post('posting_date');   
			$date_old             = $this->input->post('date_old');
			$due_date             = $this->input->post('due_date');			
			$agreement_type             = $this->input->post('agrtype');
          
			
        	$idx=$this->model_postdate->insertpostdate($posting_date,$date_old,$periode,$agreement_type,$due_date);

        	redirect("postdate/postdate/postdatelist");
        }
    }

    function postdate_edit(){
		if ($_POST){
			$periode             = $this->input->post('iperiode');
            $posting_date             = $this->input->post('posting_date');   
			$date_old             = $this->input->post('date_old');
			$due_date             = $this->input->post('due_date');			
			$agreement_type             = $this->input->post('agreement_type');
			
		// echo ($agreement_type);
		// exit;
		
		$this->model_postdate->updatepostdate($posting_date,$date_old,$periode,$agreement_type,$due_date);


		redirect("postdate/postdate/postdatelist");
		}
    }

	function postdate_delete(){

        $i_link = $this->uri->segment(4);
		$periode = $this->uri->segment(5);
		$type = $this->uri->segment(6);
		
        $posting_date = str_replace('_', '/', $i_link);

		$this->model_postdate->deletepostdate($posting_date,$periode,$type);
		redirect("postdate/postdate/postdatelist");
	}

    function postdateprintpdf(){
                $i_link = $this->uri->segment(4);
                $postdate_id = str_replace('_', '/', $i_link);

                $vsc=$this->model_postdate->getservicecharge($postdate_id);
                $vhargasc=$vsc['servicecharge'];

                $vpl=$this->model_postdate->getpromolevy($postdate_id);
                $vpromolevy=$vpl['promolevy'];

                $dps=$this->model_postdate->getdepositr($postdate_id);
                $vdps=$dps['depositr'];



        $data   = array(
                  'result'    => $this->model_postdate->viewpostdateprint($postdate_id),
                  'postdate_id'   => $postdate_id,
                  'vunit'    => $this->model_postdate->getunitpostdate($postdate_id),
                  'vhargasewa'    => $this->model_postdate->gethargasewa($postdate_id),
                  'vhargasc' =>$vhargasc,
                  'vpromolevy' =>$vpromolevy,
                  'vdps' =>$vdps

               );

        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_postdate->sholdetilby_id($postdate_id);

        $html=$this->load->view('postdate/rptpostdate', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptpostdate.pdf";
        //$this->m_pdf->pdf->SetFont('zaskiagothic');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");


    }


    function printconpdf(){
                $i_link = $this->uri->segment(4);
                $postdate_id = str_replace('_', '/', $i_link);

                $vsc=$this->model_postdate->getservicecharge($postdate_id);
                $vhargasc=$vsc['servicecharge'];

                $vpl=$this->model_postdate->getpromolevy($postdate_id);
                $vpromolevy=$vpl['promolevy'];

                $dps=$this->model_postdate->getdepositr($postdate_id);
                $vdps=$dps['depositr'];
                $nildps=$dps['postdatedetil_baserent'];



        $data   = array(
                  'result'    => $this->model_postdate->viewconfprint($postdate_id),
                  'postdate_id'   => $postdate_id,
                  'vunit'    => $this->model_postdate->getunitpostdate($postdate_id),
                  'vhargasewa'    => $this->model_postdate->gethargasewa($postdate_id),
                  'vhargasc' =>$vhargasc,
                  'vpromolevy' =>$vpromolevy,
                  'vdps' =>$vdps,
                  'nildps' =>$nildps

               );

        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_postdate->sholdetilby_id($postdate_id);

        $html=$this->load->view('postdate/rptconf', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptpostdateconf.pdf";
        //$this->m_pdf->pdf->SetFont('zaskiagothic');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");


    }

    function uploadjpg(){
        if($_POST) {

            $postdate_id = $this->input->post('postdate_id');
            $postdate_id = str_replace('/', '_', $postdate_id);


            if (is_image($_FILES['files']['tmp_name'])) {

                $allowed = array('jpg', 'jpeg', 'png');

                if(isset($_FILES['files']) && $_FILES['files']['error'] == 0){

                    $extension = pathinfo($_FILES['files']['name'], PATHINFO_EXTENSION);

                    if(!in_array(strtolower($extension), $allowed)){
                        echo '{"status":"error"}';
                        exit;
                    }

                    if(move_uploaded_file($_FILES['files']['tmp_name'], FCPATH.'/assets/uploads/'.$postdate_id.'.'.$extension)){

                        //echo '{"status":"success"}';
                        $success = 1;
                    }
                }
            } else{
                $success = 0;
            }

        if ($success) {
            $result['files'][0] = array(
                'name'      => $postdate_id.'.'.$extension,
                'size'      => 0,
                'url'       => base_url('/assets/uploads/'.$postdate_id.'.'.$extension)
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
