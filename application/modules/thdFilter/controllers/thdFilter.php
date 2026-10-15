<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ThdFilter extends CI_Controller{
	

    function __construct(){

        parent::__construct();
        // Check login and make sure email has been verified
        check_user_login();

        $this->load->model('Thd_filter_model');
				$this->load->library('breadcrumbcomponent');
				$this->load->library('form_validation');
				$this->session->keep_flashdata('message');
    }

    function index(){
        redirect('ThdFilter/ThdFilter/agreementList');
    }

		function globalsearch_list(){

			$arcari = array(
            'region_id',
            'branch_id',
            'rekanan_id',
            'rekananshipping_line',
            'KET',
            'rekanan_name',
            'rekananshipping_name',
            'agreement_startperiod',
            'agreement_endperiod',
            'agreement_isthdexc'
         );
			return $arcari;
		}	

		function globalsearch_dialog(){

			$arcari=array('unit_name', 'region_id', 'branch_id');
			return $arcari;
		}

    function globalsearch_rekanan(){

			$arcari=array('rekanan_name','A.rekanan_id', 'B.branch_id');
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

    function globalsearch_brand(){
        $arcari=array('rekananshipping_line','rekananshipping_name','rekanan_id');
        return $arcari;
    }

    function globalsearch_agrtype(){
        $arcari=array('agreementtype_id','agreementtype_name');
        return $arcari;
    }

    function globalsearch_aging(){
        $arcari=array('jurnal_id', 'jurnal_id', 'rekanan_id');
        return $arcari;
    }

    function globalsearch_schema(){
        $arcari=array('unittype_id');
        return $arcari;
    }

		function controler_griddialog(){
				ini_set('max_execution_time', 0);
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
				ini_set('max_execution_time', 0);
        $arcari=$this->globalsearch_rekanan();
				$vResult=$this->initialize_grid("qry_alldatapop","qry_filteredpop","qry_totalallpop",$arcari,"");
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['rekanan_id'];
                    $row[]=$aRow['rekanan_id'];
                    $row[]=$aRow['rekanan_name'];
                    $row[]=$aRow['rekananshipping_line'];
                    $row[]=$aRow['rekananshipping_name'];
                    $row[]=$aRow['debtor_no'];

            if (!empty($row)) { $output['data'][] = $row; }
            }
            echo json_encode($output);

    }

    function controler_gridtenant(){
				ini_set('max_execution_time', 0);
        $arcari=$this->globalsearch_rekanan();
        $vResult=$this->initialize_grid("qry_alldatatenant","qry_filteredtenant","qry_totalalltenant",$arcari,"");
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
				ini_set('max_execution_time', 0);
        $arcari=$this->globalsearch_region();
        $vResult=$this->initialize_grid("qry_alldataregion","qry_filteredregion","qry_totalallregion",$arcari,"");
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
				ini_set('max_execution_time', 0);
        $arcari=$this->globalsearch_branch();
        $vResult=$this->initialize_grid("qry_alldatabranch","qry_filteredbranch","qry_totalallbranch",$arcari,"");
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
				ini_set('max_execution_time', 0);
        $arcari=$this->globalsearch_brand();
        $vResult=$this->initialize_grid("qry_alldatabrand","qry_filteredbrand","qry_totalallbrand",$arcari,"");
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['rekananshipping_line'];
                    $row[]=$aRow['rekananshipping_line'];
                    $row[]=$aRow['rekananshipping_name'];

            if (!empty($row)) { $output['data'][] = $row; }
            }
            echo json_encode($output);

    }

    function controler_gridagrtype(){
				ini_set('max_execution_time', 0);
        $arcari=$this->globalsearch_agrtype();
        $vResult=$this->initialize_grid("qry_alldataagrtype","qry_filteredagrtype","qry_totalallagrtype",$arcari,"");
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['agreementtype_id'];
                    $row[]=$aRow['agreementtype_id'];
                    $row[]=$aRow['agreementtype_name'];

            if (!empty($row)) { $output['data'][] = $row; }
            }
            echo json_encode($output);

    }
	
		function controler_gridaging(){
			ini_set('max_execution_time', 0);
        $arcari=$this->globalsearch_aging();
        $vResult=$this->initialize_grid("qry_alldataaging","qry_filteredaging","qry_totalallaging",$arcari,"");
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['jurnal_id'];
					$row[]=$aRow['jurnal_id'];
					$row[]=$aRow['jurnaldetil_line'];
                    $row[]=$aRow['jurnal_descr'];
					$row[]=number_format($aRow['jurnaldetil_selisih'], 2, '.', ',');
					$row[]='<input type="text" id="tamt[]" name="tamt[]" value="0" class="clsamt detil bulet form-control input-sm" style= "text-align: right;"/>';

            if (!empty($row)) { $output['data'][] = $row; }
            }
            echo json_encode($output);

    }

    function controler_gridschema(){
        $arcari=$this->globalsearch_schema();
        $vResult=$this->initialize_grid("qry_alldataschema","qry_filteredschema","qry_totalallschema",$arcari,"");
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
            $row[]=$aRow['skl_cp'];

            if (!empty($row)) { $output['data'][] = $row; }
            }
            echo json_encode($output);

    }
		
		function initialize_grid($qry_alldata, $qry_filtered, $qry_totalall, $arcari, $cariOptional = '', $searchStatus = '')
      {
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
			$sWhereUser = "";

         $excludes = array(
            'agreement_startperiod', 
            'agreement_isthdexc' 
         );

			if ( isset($_POST['search']['value']) && $_POST['search']['value'] != "" ) {
				$sWhere = "(";
				for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
               if (in_array($aColumns[$i], $excludes)) { continue; }
					// if ($aColumns[$i]=='rekanan_id')
					// {
						// $sWhere .= $aColumns[$i]." LIKE '" . "'%" .addslashes( $_POST['search']['value'] ). "%'" . "' OR ";
					// }
					// else
					// {
						$sWhere .= $aColumns[$i]." LIKE ''%".addslashes( $_POST['search']['value'] )."%'' OR ";
					// }
					
				}
				$sWhere = substr_replace( $sWhere, "", -3 );
				$sWhere .= ')';
			}
      
			for ($i=0; $i < count($aColumns); $i++) {
            
            if ($aColumns[$i] == 'agreement_isthdexc'){ continue; }

				if ( isset($_POST['columns'][$i]['search']['value']) && $_POST['columns'][$i]['search']['value'] != "" ) {

						$searchCol = trim($_POST['columns'][$i]['search']['value']);

						if ($searchCol != '') {
								if ($sWhere != ''){
										if ($aColumns[$i] == 'agreement_startperiod'){
											$sWhere .= " AND agreement_startperiod >= "."''".$searchCol."''";
										}				
										elseif ($aColumns[$i] == 'agreement_endperiod'){
												$sWhere .= " AND agreement_endperiod <= "."''".$searchCol."''";
										}
										elseif ($aColumns[$i] == 'KET'){
											//$sWhere .= " AND KET = "."'".$searchCol."'";											
											if ($searchCol!='ALL') {
												$sWhere .= " AND KET = "."''".$searchCol."''";
											}
										}
										else {
											$sWhere .= " AND ". $aColumns[$i] . " LIKE ''%".$searchCol."%''";
										}
										
								} else {
									
						
										if ($aColumns[$i] == 'agreement_startperiod'){
											$sWhere .= " agreement_startperiod >= "."''".$searchCol."''";
										}																	
										elseif ($aColumns[$i] == 'agreement_endperiod'){
											$sWhere .= " agreement_endperiod <= "."''".$searchCol."''";
										}								
										elseif ($aColumns[$i] == 'KET'){
											if ($searchCol!='ALL') {
												$sWhere .= " KET = "."''".$searchCol."''";
											}
										}
										else {
												$sWhere .= $aColumns[$i] . " LIKE ''%".$searchCol."%''";
										}
								}
							}
					}
			}

			$top = (isset($_POST['start']))?((int)$_POST['start']): 0 ;
			$limit = (isset($_POST['length']))?((int)$_POST['length'] ): 10 ;
			$limit = $limit + $top;
			
			if ( $cariOptional <> '' ) {            
					$sWhere = $sWhere <> '' ? $sWhere." AND ".$cariOptional : " WHERE ".$cariOptional;
			}

         
         // Additional Search
         for ($i=0; $i < count($aColumns); $i++) {

            $searchVal = trim($_POST['columns'][$i]['search']['value']);
            
            if ($aColumns[$i] == 'agreement_isthdexc') {
               $searchVal = $searchVal == '' ? 0 : $searchVal;
               if ($sWhereUser == '') {
                  $sWhereUser = " agreement_isthdexc =  ".$searchVal;
               } else {
                  $sWhereUser = " and agreement_isthdexc = ".$searchVal;
               }
            }			
			}

         /*
			$username=$this->session->userdata('username');
			if ($sWhere =='') {
				$sWhereUser = " where username = "."'".$username."'";
			}
					else
			{
				$sWhereUser = " and username = "."'".$username."'";
			}
         */

			
			$rResult=$this->Thd_filter_model->$qry_alldata($limit, $top, $sWhere, $sWhereUser);

			$rResultCnt =$this->Thd_filter_model->$qry_filtered($sWhere, $sWhereUser);
			$iFilteredTotal = $rResultCnt['jml'];

			$rResultTotal =$this->Thd_filter_model->$qry_totalall($sWhereUser);
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

		function controler_gridlist($val_search = ''){


				ini_set('max_execution_time', 0);
				$arcari=$this->globalsearch_list();
				$searchStatus = $val_search;

				//alert($searchStatus);
				$timestamp = time();
				$now = date("Y-m-d", $timestamp);
				$updatedate = 0;
				$qry_alldatalist = "qry_alldatalist";
				$qry_filteredlist = "qry_filteredlist";
				$qry_totalalllist = "qry_totalalllist";
				$criteria = null;
				
									
				//mudules::run('m');
				//$del =modules::run('master_rekananshipping/destroy',$rekanan_id,$rekananshipping_line);
				// echo "bug -->".$criteria; exit;

				$vResult=$this->initialize_grid($qry_alldatalist,$qry_filteredlist,$qry_totalalllist,$arcari,$criteria,$searchStatus);
				$rResult=$vResult['rResult'];
				$output=$vResult['output'];

				foreach ($rResult as $aRow) {

							//$i_link = str_replace('/', '_', $aRow['invoice_id']);
							//$tenant = substr($aRow['rekanan_name'], 0, 15) . '...';

							$row = array();
							$row[]=$aRow['agreement_id'];
							$row[]=$aRow['agreement_contractno'];
							$row[]=$aRow['rekanan_namereport'];
							$row[]=$aRow['rekananshipping_name'];
							$row[]=$aRow['agreement_contractlongnumber'];
							$row[]=$aRow['TLV'];
							$row[]=$aRow['agreement_startperiod'];
							$row[]=$aRow['agreement_endperiod'];
							$row[]=$aRow['agreement_bapdate'];
							$row[]=$aRow['unit'];
							$row[]=$aRow['area'];
							$row[]=$aRow['ISCLOSED'];
							$row[]=$aRow['ISAPPROVED'];
							$row[]=$aRow['KET'];

							if (!empty($row)) { $output['data'][] = $row; }
				}

			echo json_encode($output);

		}

    function controler_gridlistSearch($val_search = '',$nil_search = ''){
				$arcari=$this->globalsearch_list();
				$searchStatus = $val_search;
				$searchNilai = $nil_search;


				$criteria = null;
				if($searchStatus == '1')
				{
					if(!empty($criteria))
					{
						$criteria = $criteria." AND region_id = $searchNilai";
					}
					else
					{
						$criteria =  " agreementtype_printouttype = 1";
					}
				}
				elseif($searchStatus == '2')
				{
					if(!empty($criteria))
					{
						$criteria = $criteria." AND agreementtype_printouttype = 2";
					}
					else
					{
						$criteria =  " agreementtype_printouttype = 2";
					}
				}
				elseif($searchStatus == '3')
				{
				if(!empty($criteria))
				{
					$criteria = $criteria." AND agreementtype_printouttype = 3";
				}
				else
				{
					$criteria =  " agreementtype_printouttype = 3";
				}
			}
			elseif($searchStatus == '4')
			{
				if(!empty($criteria))
				{
					$criteria = $criteria." AND B.region_id = 0";
				}
				else
				{
					$criteria =  " B.region_id = 0";
				}
			}
			else
			{
				$criteria =  null;
			}


      $vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari,$criteria);
      $rResult=$vResult['rResult'];
      $output=$vResult['output'];

      foreach ($rResult as $aRow) {

            $i_link = str_replace('/', '_', $aRow['schedulepayment_id']);
            $ship_name = substr($aRow['rekanan_name'], 0, 15) . '...';

                $_menu='
                    <a href="/index.php/looprint/looprint/looprintpdf/'.$i_link.'" data-toggle="tooltip" title="Print" target="_blank">
                    <img border="0" src="/assets/img/print.png" width="21" height="21"> </a>';


            $row = array();

               $row[]=$aRow['schedulepayment_id'];
               $row[]=$aRow['invoice_id'];
               $row[]=$aRow['faktur_id'];
               $row[]=$aRow['region_nameshort'];
               $row[]=$aRow['branch_name'];
               $row[]=$ship_name;
               $row[]=$aRow['rekananshipping_name'];
               $row[]=$aRow['agreementtype_name'];
               $row[]=$aRow['schedulepaymentdetil_descr'];
               $row[]=date("d-m-Y", strtotime($aRow['schedulepaymentdetil_date']));
               $row[]=date("d-m-Y", strtotime($aRow['schedulepaymentdetil_duedate']));
               $row[]=date("d-m-Y", strtotime($aRow['schedulepaymentdetil_proformadate']));
               $row[]=$aRow['schedulepaymentdetil_amount'];
               $row[]=$aRow['schedulepaymentdetil_idr'];
               $row[]=$_menu;

            if (!empty($row)) { $output['data'][] = $row; }
          }
          echo json_encode($output);

    }

    function agreementList(){

        $loo_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->Thd_filter_model->viewinvoice($loo_id),
                  'loo_id'   => $loo_id,
                  'branch' => $this->branch_select()
            );

        $data['region'] = $this->region_select();
        $data['agrtype'] = $this->agrtype_select();
        //$data['branch'] = $this->branch_select();

				$this->breadcrumbcomponent->add('THD Filter','thdFilter/agreementList');

        $this->load->view('template/v_header');
        $this->load->view('thdFilter/agreement_list', $data);
        $this->load->view('template/v_footer');
    }

    function region_select(){
        $this->load->model('template/Master_m');
        $username=$this->session->userdata('username');

        $region     = $this->Thd_filter_model->getregion($username);
        //$options    = array('' => 'Select an option');

        if(count($region)){
            foreach($region as $key => $value){
                $options[$value->region_id]= $value->region_name;
            }
        }

        return $options;
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

    function tenant_select(){

        $rSearch = empty($_GET['term']) ? '' : $_GET['term'];
        //$rRegion = empty($_GET['region']) ? '' : $_GET['region'];


        if (is_array($rSearch) && $rSearch['_type'] == 'query'){

            $this->load->model('template/Master_m');

            $tenant      = $this->Master_m->get_tenant($rSearch['term']);

            $result['items']= $tenant;

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

        $lType = empty($_GET['lootype']) ? '' : $_GET['lootype'];
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
                if ( $value->unittype_id != 6 && $value->unittype_id != 7){

                    $options[$value->unittype_id]= $value->unittype_name;
                }
            }
        }

        return $options;
    }

    function lootype_select(){

        $options    = array('' => '==Pilih==');

        $options[0] = 'Permanent Leasing';
        $options[1] = 'Casual Leasing';

        return $options;
    }  
		
		function invoicing_Export(){

				$region_id = $this->input->post('hregion');
        $region_name = $this->input->post('iregion');
        $branch_id = $this->input->post('hbranch');
        $branch_name = $this->input->post('ibranch');
        $rekanan_id = $this->input->post('htenant');
        $rekanan_name = $this->input->post('itenant');
        $rekananshipping_line = $this->input->post('hbrand');
        $rekananshipping_name = $this->input->post('ibrand');
        $startdate = $this->input->post('iperiodefrom');
        $enddate = $this->input->post('iperiodeend');
        $button			= $this->input->post('button');
				$invoicetype			= $this->input->post('invoicetype');
				$cdatefrom = $this->input->post('cperiodefrom');
				$cdateend = $this->input->post('cperiodeend');
				$where = $this->input->post('hcriteria');
		
				$where =' where schedulepaymentdetil_isposted = 0 and schedulepaymentdetil_ischecked = 0 ';
				$button ='EXCEL';
				
				if (isset($region_id)){
					$where =$where . ' and B.region_id = ' ."'".$region_id."'";
				}
				if ($branch_id ==! ''){
					$where =$where. ' and B.branch_id = ' ."'".$branch_id."'";
				}
				if ($rekanan_id ==! ''){
					$where =$where. ' and B.rekanan_id = ' ."'".$rekanan_id."'";
				}
				if ($rekananshipping_line ==! ''){
					$where =$where. ' and B.rekananshipping_line = ' ."'".$rekananshipping_line."'";
				}
				if ($startdate ==! ''){
					$where =$where. ' and schedulepaymentdetil_date >= ' ."'".$startdate."'" .' and schedulepaymentdetil_date <= '."'".$enddate."'";
				}
				if ($invoicetype ==! ''){
					$where =$where. ' and agreementtype_printouttype = ' ."'".$invoicetype."'";
				}

						$data   = array(
											'result'      => $this->model_invoice->qry_invoicelist($where),
											//'resultdetil'      => $this->model_soprptprint->viewinvprintdetil($loo_id),
											//'unitspace'  => $this->model_soprptprint->getunitspace()
											'region_id'   => $region_id,
											'branch_id'   => $branch_id,
											'rekanan_id'   => $rekanan_id,
											'rekananshipping_line'   => $rekananshipping_line,
							'region_name'   => $region_name,
											'branch_name'   => $branch_name,
											'rekanan_name'   => $rekanan_name,
											'rekananshipping_name'   => $rekananshipping_name,
											'startdate'   => $startdate,
											'enddate'   => $enddate,
							'button'     => $button
									);
				//echo $where;
				//print_r($data);
				//exit;
				
				$this->load->view('invoicing/rptexcel', $data);
			
        
    }
      

		public function exclude_include_thd() {
	
         $id = $this->input->post('id');
         $isExclude = $this->input->post('isexclude');
         $excl_by = $this->session->userdata('user_fullname');	  
         $button = $this->input->post('button');

         $res = $this->Thd_filter_model->update_THD($id, $isExclude, $excl_by);

         if (!empty($invidx)){
            $data['pesan'] = 'successful invoicing';
         }
         else {
            $data['pesan'] = 'unsuccessful invoicing';
         }
      
      
         //echo ($invoice_id);
         echo json_encode($data);

      }

}
