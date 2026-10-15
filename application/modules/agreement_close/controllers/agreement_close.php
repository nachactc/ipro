<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
 


class Agreement_close extends MX_Controller
{

    public function __construct() 
    {
        parent::__construct();      
		check_user_login();   
        $this->load->model('model_agreementclose'); 
		$this->load->library('breadcrumbcomponent'); 		
    }
    
	function globalsearch_list(){
		$arcari=array('a.agreement_id','c.branch_name','d.rekanan_name','e.rekananshipping_name','a.agreement_contractno');
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
				$searchCol = trim($_POST['columns'][$i]['search']['value']);
				if ($searchCol != '') {
					if ($sWhere != ''){             
						$sWhere .= " AND ". $aColumns[$i] . " LIKE '%".$searchCol."%'";
					} else {
						$sWhere = "WHERE ". $aColumns[$i] . " LIKE '%".$searchCol."%'";
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
		
		$rResult=$this->model_agreementclose->$qry_alldata($limit,$top,$sWhere);
			
		$rResultCnt =$this->model_agreementclose->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_agreementclose->$qry_totalall();
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

	function controler_gridlist($val_search = '',$val_serach_branch=''){
		$arcari=$this->globalsearch_list(); 
		$searchStatus = $val_search;
		
		
		$criteria = null;  
		if($searchStatus == 'k')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND a.agreement_isclosed = 0 AND a.agreement_isapproved = 1";
			}
			else
			{
				$criteria =  " AND a.agreement_isclosed = 0 AND a.agreement_isapproved = 1";
			}	 
		}
		elseif($searchStatus == 'avail')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND a.agreement_isclosed = 0  ";
			}
			else
			{
				$criteria =  " a.agreement_isclosed = 0 ";
			}	
		} 
		elseif($searchStatus == 'close')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND a.agreement_isclosed = 1  ";
			}
			else
			{
				$criteria =  " a.agreement_isclosed = 1 ";
			}	
		}
		else
		{
			$criteria =  " a.agreement_isclosed = 0 ";
		}
		if($val_serach_branch != '')
		{
			if($criteria != '')
			{
				$criteria = $criteria . " and a.branch_id = '$val_serach_branch'";
			}
			else
			{
				$criteria =	"  a.branch_id = '$val_serach_branch'";
			}
		}  
		//echo $criteria;
    	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari,$criteria);
    	$rResult=$vResult['rResult'];
    	$output=$vResult['output'];

    	foreach ($rResult as $aRow) {
 
            $ship_name = substr($aRow['rekanan_name'], 0, 15) . '...'; 
			
			$id = trim($aRow['agreement_id']);
			////agc4/index.php/agreement_close/agrclose_data/'.$id.'
			if($aRow['agreement_isclosed'] == 0)
			{
				$_menu=' 
				<span class="glyphicon glyphicon-check closeData"  id="CloseIDData"></span>
				<a href="/index.php/agreement_close/agreementpdf/'.$id.'" data-toggle="tooltip" title="Print" target="_blank">
				<span class="glyphicon glyphicon-print"></span>  </a>        
				 '; 
			}
			else
			{
				$_menu='  
				<a href="/index.php/agreement_close/agreementpdf/'.$id.'" data-toggle="tooltip" title="Print" target="_blank">
				<span class="glyphicon glyphicon-print"></span>  </a>        
				 '; 
			}

           

            $row = array();

			$row[]=$aRow['agreement_id'];
            $row[]=date("d-m-Y", strtotime($aRow['agreement_createdate']));
            $row[]=date("d-m-Y", strtotime($aRow['agreement_startdate']));
            $row[]=date("d-m-Y", strtotime($aRow['agreement_enddate']));
			$row[]=$aRow['agreement_term'];
			$row[]=$aRow['region_name'];
			$row[]=$aRow['branch_name'];
            $row[]=$ship_name;
            $row[]=$aRow['rekananshipping_name'];
            $row[]=$aRow['agreement_contractno'];
            $row[]=$aRow['agreement_virtualaccount'];
			$row[]=$_menu;
    	
            if (!empty($row)) { $output['data'][] = $row; }
        	}   
        	echo json_encode($output);
    		
    }

	 function agreementlist(){
        
        $agreement_id = $this->uri->segment(4);
        $data   = array(
                  //'result'    => $this->model_agreementclose->viewAgreement($agreement_id),
                  'agreement_id'   => $agreement_id,
				  'branch'		   => $this->model_agreementclose->get_branch_list()
            );        
        
        
		
		$this->breadcrumbcomponent->add('Agreement Close','agreement_close/agreementlist');

        $this->load->view('template/v_header');
        $this->load->view('agreement_close/view', $data);
        $this->load->view('template/v_footer');
    }
   

    /**
    * List all data La_received
    *
    */
    public function index() 
    { 
        redirect('agreement_close/agreementlist'); 
    }

    public function agrclose_data()
	{
		//echo var_dump($_POST);exit;
		
		$id = $this->input->post('agreement_id');
		//echo $id;exit;
		if($id != ''){
			$result = $this->model_agreementclose->AgreementClose( );
			redirect('agreement_close');
		}
		else{
			redirect('agreement_close');
		}
		
	}
	
	function agreementpdf($id){          
       
        $ang=$this->model_agreementclose->getangsuran($id); 
		
        $max_ang = (max($ang));

        $vang=$max_ang['angsuran'];
		$vang = $vang == '' ? 1 : $vang;
		//echo var_dump($vang);exit;
        
 
        $data   = array( 
                  'schedule'      => $this->model_agreementclose->get_schedule($id),
				  'vunit'         => $this->model_agreementclose->getunitloo($id),       
                  'result'        => $this->model_agreementclose->get_header($id), 
				  'vang'          => $vang,
				  'vruangsewa'    => $this->model_agreementclose->get_ruang($id),
				  'vhargasewa'    => $this->model_agreementclose->gethargasewa($id),
				  'vhargasc'      => $this->model_agreementclose->getservicecharge($id),
				  'vtotallease'   => $this->model_agreementclose->gettotallease($id),
				  'vhargapromo'   => $this->model_agreementclose->gethargapromo($id),
                  'vhargafood'    => $this->model_agreementclose->gethargafoodcourt($id),
				  'vdepe'         => $this->model_agreementclose->getdepe($id),
				  'vdeposit'      => $this->model_agreementclose->getdeposit($id),
				  'vtdep'         => $this->model_agreementclose->gettdep($id),
               );

        /** FORMULA UNTUK MEMBUAT CROSTAB TAB TAB**/
        $x_row        = array();
        $y_col        = array();
        $zcross_tab   = array();
        $xTotal       = array();
        $yTotal       = array(); 
        foreach($data['schedule'] as $sched){  

            $_startdate = date_create($sched->agreement_startdate);           
            $interval = new DateInterval('P12M');

            $_startdate->add($interval);
            $_startdate->modify('first day of this month');;

            //echo $_startdate('Y-m-d');            
            //echo $_startdate->format('jS, F Y');
            //echo date('Y-m-d', $_startdate);
            
            $ex_title = explode('|', $sched->sp_col);
            $_title = $ex_title[1];            

            if (date_create($sched->sp_date) >= $_startdate && $_title == 'Biaya Pelayanan') { 
                $installment_idr = 0; 
            }else{

                $installment_idr = $sched->sp_amount;
                $x_row[$sched->sp_date][] = $sched->sp_amount;
                $y_col[$sched->sp_col][] = $sched->sp_amount;

            }        

            $zcross_tab[$sched->sp_col.'_'.$sched->sp_date] = $installment_idr;
        }
       
        foreach($x_row as $id => $amount){
            $rowLabel[]   = $id;
            $xTotal[$id]  = array_sum($amount);
        }

        foreach($y_col as $id => $amount){  
            $colLabel[]   = $id;          
            $yTotal[$id]  = array_sum($amount);
        }
        /** END FORMULA CROSSTAB **/
        
        asort($colLabel);
        $data['collabel']     = $colLabel;
        $data['rowlabel']     = $rowLabel;
        $data['xtotal']       = $xTotal;
        $data['ytotal']       = $yTotal;
        $data['zcross_tab']   = $zcross_tab; 

        $data['resultd'] = $this->model_agreementclose->getunitloo($id);    
         
		//$this->load->view('agreement_close/view_pdf', $data);
		
       $html=$this->load->view('agreement_close/view_pdf', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "view_pdf.pdf";

        $this->m_pdf->pdf->simpleTables = true;

        $this->m_pdf->pdf->packTableData = true;

        $this->m_pdf->pdf->AddPage('P','','','','',30,10,25,15,8,8);
        $this->m_pdf->pdf->WriteHTML($html);       
        $this->m_pdf->pdf->Output($pdfFilePath, "I");     


    }
 
}

?>
