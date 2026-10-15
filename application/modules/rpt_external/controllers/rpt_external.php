<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rpt_external extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_external'); 
		$this->load->library('breadcrumbcomponent');
		$this->load->helper(array('form', 'url'));
    }
    
	 
	function index(){       
        redirect('rpt_external/external_list');
    }
  
    function external_list(){
        		
		$this->breadcrumbcomponent->add('Report External','rpt_external/external_list'); 
		$data['agrType'] = $this->Agr_select();
		$data['GroupTenantType'] = $this->GroupTenant_select();
		$data['GradeProperty'] = $this->PropertyGrade_select();
		$this->session->unset_userdata('criteriaSess');
   
        $this->load->view('template/v_header');
        $this->load->view('rpt_external/external_list',$data);
        $this->load->view('template/v_footer');
    }
	 
   
    function Agr_select(){ 
        
        $hasil     = $this->model_external->get_AgrGroup();
        //$options    = array('' => 'Select an option');                
        
        if($hasil != 'kosong'){
            foreach($hasil as $key => $value){
				$options[''] = '';
                $options[$value->agrtypegroup_id]= $value->agrtypegroup_name;
            }
		}
		else
		{
			$options[''] = '';
		}
                    
        return $options;
    }
	
    function GroupTenant_select(){ 
        
        $hasil     = $this->model_external->get_GroupTenant();
        //$options    = array('' => 'Select an option');                
        
        if($hasil != 'kosong'){
            foreach($hasil as $key => $value){
				$options[''] = '';
                $options[$value->grouptenant_id]= $value->grouptenant_name;
            }
        }
		else
		{
			$options[''] = '';
		}
                    
        return $options;
    }
	
    function PropertyGrade_select(){ 
        
        $hasil     = $this->model_external->get_PropertGrade();
        //$options    = array('' => 'Select an option');                
        
        if($hasil != 'kosong'){
            foreach($hasil as $key => $value){
				$options[''] = '';
                $options[$value->branch_id]= $value->branch_name;
            }
        }
		else
		{
			$options[''] = '';
		}
                    
        return $options;
    }
   
    function report_load()
    {  
		$array_items = array('channel', 'criteria'); 
		$this->session->unset_userdata($array_items);
		$bln = $this->input->post('bln');
		$thn = $this->input->post('tahun');
		$acc_id = $this->input->post('acc_id');
		$region_id = $this->input->post('region_ids'); 
		$branch_id = $this->input->post('branch_id');
		$rekanan_id = $this->input->post('rekanan_id');
		$rekananshipping_line = $this->input->post('rekananshipping_id');
		$advance =  $this->input->post('advance');
		//echo $incl_ppn;exit;
		$startdate =  $this->input->post('startdate');
		$enddate =  $this->input->post('enddate');
		
		$txtSearchCriteria = '';
		$thn = ($thn === 'Pilih') ? '' : $thn;
		$bln = ($bln === 'Pilih') ? '' : $bln;
		$periode = $thn.$bln;
		
		// echo var_dump($_POST); 
		// exit;
		if($startdate != '')
		{
			if($txtSearchCriteria == '')
			{ 
				$txtSearchCriteria = "a.jurnal_bookdate >= ''$startdate'' "; 
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND a.jurnal_bookdate >= ''$startdate'' ";
			}
		}
		if($enddate != '')
		{
			if($txtSearchCriteria == '')
			{ 
				$txtSearchCriteria = "a.jurnal_bookdate <= ''$enddate'' "; 
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND a.jurnal_bookdate <= ''$enddate'' ";
			}
		}
		if($bln != '' and $thn != '' )
		{
			if($txtSearchCriteria == '')
			{ 
				$txtSearchCriteria = "a.periode_id = ''$periode'' "; 
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND a.periode_id = ''$periode'' ";
			}
		}
		if($advance != '')
		{
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = $advance;
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND $advance ";
			}
		}
		if($region_id <> 0)
		{
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = " b.region_id = ''$region_id''";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND  b.region_id = ''$region_id'' ";
			}
		}
		if($branch_id <> 0)
		{
			
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = "b.branch_id = ''$branch_id''";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND b.branch_id = ''$branch_id'' ";
			}
			
		}
		if($rekanan_id <> 0)
		{
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = "b.rekanan_id = ''$rekanan_id''";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND  b.rekanan_id = ''$rekanan_id'' ";
			}
		}
		if($rekananshipping_line <> 0 )
		{
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = " b.rekananshipping_line = '$rekananshipping_line'";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria."  AND b.rekananshipping_line = ''$rekananshipping_line'' ";
			}
		}
		if($acc_id <> 0 )
		{
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = "b.acc_id = ''$acc_id'' ";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND  b.acc_id = ''$acc_id'' ";
			}
		}
		$criteria=$txtSearchCriteria;
		//echo var_dump($_POST);exit;
		
		$criteriaSession ='';
		
		if(empty($criteriaSession))
		{
			$this->session->set_userdata('criteriaSess', $criteria);
			$this->session->set_userdata('criteriaSess', $criteria);
			$criteriaSession = $this -> session -> userdata('criteriaSess');
			$criteria = $criteriaSession;
		}
		// echo "<pre/>";
		// echo var_dump($this -> session -> userdata());
		// echo "<pre/>";
		// echo var_dump($criteriaSession);//exit; 
		
		$report_type = $this->input->post('report_type');
		$channel_id = '';
		$reportView = '';
		//echo $this->uri->segment(4);exit;
		//echo $report_type;exit;
		$newdata = array(
					'channel_id'  => $channel_id, 
					'criteria' => $criteria 
			); 
		$this->session->set_userdata($newdata);

		//var_dump($criteria);exit;		 
		$data['result'] = $this->model_external->get_ReportExternal($channel_id,$criteria );
		//echo count($data['result']); //exit;
		$reportView = 'rpt_external/report_external'; 
		$data['title'] = 'External Journal'; 
		$this->load->view($reportView,$data);
		
    }
	
	function report_excel(){

        $this->load->library("Excel/PHPExcel");
		PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );
		
		$channel_id = $this->session->userdata('channel_id'); 
		$criteria = $this->session->userdata('criteria'); 
					
        $prof = $this->model_external->get_ReportExternal($channel_id,$criteria );
		 
		//membuat objek PHPExcel
        $objPHPExcel = new PHPExcel();
		
		// echo var_dump($prof);
		// exit; 
        $tRegion = '';

        if (!empty($prof)){
          $tRegion = $prof[0]->region_name;
        }

        
		 // auto fit column to content
        foreach(range('A','O') as $columnID) {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
          ->setAutoSize(true);
        }
        // add style to the header
        $styleArray = array(
          'font' => array(
            'bold' => true,
          ),
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          ),
          'borders' => array(
            'outline' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
          ),
        );
		
		$stylehURUF = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			)
		);

        $styleBody = array(              
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
          ),
        );
		
        $objPHPExcel->getActiveSheet()->mergeCells('A1:Q1');        
        $objPHPExcel->getActiveSheet()->mergeCells('A2:R2');        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A1", $tRegion);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A2", "External Journal Tanggal ".strtoupper(getIndoHari(date('Y-m-d'))) );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A3", "TOTAL ROW(S) ".number_format(count($prof),0,',','.'));
		$objPHPExcel->setActiveSheetIndex(0)->getStyle("A1:R1")->applyFromArray($stylehURUF);
		$objPHPExcel->setActiveSheetIndex(0)->getStyle("A2:QR2")->applyFromArray($stylehURUF);
        
        // auto fit column to content
        foreach(range('A','R') as $columnID) {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
          ->setAutoSize(true);
        }
        // set the names of header cells
        $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue("A4",'Entitiy Cd')
          ->setCellValue("B4",'Entity Name')
          ->setCellValue("C4",'A/c Code')
          ->setCellValue("D4",'Description')
          ->setCellValue("E4",'Debtor')
          ->setCellValue("F4",'Name')
          ->setCellValue("G4",'Brand')
          ->setCellValue("H4",'Financial Period')
          ->setCellValue("I4",'Journal Date')
          ->setCellValue("J4",'Journal No') 
          ->setCellValue("K4",'Reference No') 
          ->setCellValue("L4",'Reference Ln') 
          ->setCellValue("M4",'Trx Description')
          ->setCellValue("N4",'Tax Invoice No')
          ->setCellValue("O4",'Invoice No')
          ->setCellValue("P4",'Debit')
          ->setCellValue("Q4",'Credit')
          ->setCellValue("R4",'Balance');

        $objPHPExcel->getActiveSheet()->getStyle('A4:R4')->applyFromArray($styleArray);

        // Add some data
        $x= 5;
        $y= 5;        
	
        foreach($prof as $sub){
			 
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue("A$x",$sub->branch_code)
          ->setCellValue("B$x",$sub->branch_name)
          ->setCellValue("C$x",$sub->acc_id)
          ->setCellValue("D$x",$sub->jurnal_descr)
          ->setCellValue("E$x",$sub->debtorname)
          ->setCellValue("F$x",$sub->rekanan_name)
          ->setCellValue("G$x",$sub->rekananshipping_name)
          ->setCellValue("H$x",$sub->periode_id)
          ->setCellValue("I$x",$sub->jurnal_bookdate)
          ->setCellValue("J$x",$sub->jurnal_id)
          ->setCellValue("K$x",$sub->ref_id)
          ->setCellValue("L$x",$sub->ref_line)
          ->setCellValue("M$x",$sub->jurnaldetil_descr)
          ->setCellValue("N$x",$sub->faktur_id)
          ->setCellValue("O$x",$sub->invoice_id)
          ->setCellValue("P$x",($sub->jurnaldetil_idr > 0) ? ($sub->jurnaldetil_idr) : 0)
          ->setCellValue("Q$x",($sub->jurnaldetil_idr < 0) ? ($sub->jurnaldetil_idr) : 0)
          ->setCellValue("R$x",$sub->jurnaldetil_idr);
		$x++;
		$objPHPExcel->getActiveSheet()->getStyle("I$x")
			->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
		//$y = $x;
        }

        $objPHPExcel->getActiveSheet(0)->setCellValue("O$x", 'Total');  
        $objPHPExcel->getActiveSheet(0)->setCellValue("P$x","=SUM(P$y:P".($x-1).")");
        $objPHPExcel->getActiveSheet(0)->setCellValue("Q$x","=SUM(Q$y:Q".($x-1).")");
        $objPHPExcel->getActiveSheet(0)->setCellValue("R$x","=SUM(R$y:R".($x-1).")"); 
		 
		
        $objPHPExcel->getActiveSheet(0)->getStyle("N$x:R$x")->getFont()->setBold(true);  
        $objPHPExcel->getActiveSheet(0)->getStyle("A5:R$x")->applyFromArray($styleBody); 
        $objPHPExcel->getActiveSheet(0)->getStyle("O5:R$x")->getNumberFormat()->setFormatCode('#,##0.00');   
        $objPHPExcel->getActiveSheet(0)->setTitle('External Journal');

        //mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5          
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();

        //sesuaikan headernya 
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //ubah nama file saat diunduh
        header('Content-Disposition: attachment;filename="ExternalJournal_'.date("Y-m-d").'.xlsx"');
        //unduh file
        $objWriter->save("php://output"); 
        exit; 
    }
	
	
	function branch_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_external->get_branch_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function acc_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_external->get_acc_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function region_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_external->get_region_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function rekanan_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_external->get_rekanan_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function rekananshipping_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_external->get_rekananshipping_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
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
 
}  