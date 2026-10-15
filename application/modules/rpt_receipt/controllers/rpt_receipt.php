<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rpt_receipt extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_receipt'); 
		$this->load->library('breadcrumbcomponent');
		$this->load->helper(array('form', 'url'));
    }
    
	 
	function index(){       
        redirect('rpt_receipt/receipt_list');
    }
  
    function receipt_list(){
        		
		$this->breadcrumbcomponent->add('Report Receipt','rpt_receipt/receipt_list'); 
		$data['agrType'] = $this->Agr_select();
		$data['GroupTenantType'] = $this->GroupTenant_select();
		$data['GradeProperty'] = $this->PropertyGrade_select();
		$this->session->unset_userdata('criteriaSess');
   
        $this->load->view('template/v_header');
        $this->load->view('rpt_receipt/receipt_list',$data);
        $this->load->view('template/v_footer');
    }
	 
   
    function Agr_select(){ 
        
        $hasil     = $this->model_receipt->get_AgrGroup();
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
        
        $hasil     = $this->model_receipt->get_GroupTenant();
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
        
        $hasil     = $this->model_receipt->get_PropertGrade();
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
		$startdate =  $this->input->post('start_date');
		$enddate =  $this->input->post('end_date');
		//echo $incl_ppn;exit;
		
		$txtSearchCriteria = ''; 
		$periode = $thn.$bln;
		
		// echo var_dump($_POST); 
		// exit;
		
		
		if($bln != 'Pilih' and $thn != 'Pilih' and $periode != 'PilihPilih')
		{
			if($txtSearchCriteria == '')
			{ 
				$txtSearchCriteria = "b.periode_id = '$periode' "; 
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND b.periode_id = '$periode' ";
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
				$txtSearchCriteria = " b.region_id = '$region_id'";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND  b.region_id = '$region_id' ";
			}
		}
		if($branch_id <> 0)
		{
			
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = "b.branch_id = '$branch_id'";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND b.branch_id = '$branch_id' ";
			}
			
		}
		if($rekanan_id <> 0)
		{
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = "b.rekanan_id = '$rekanan_id'";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND  b.rekanan_id = '$rekanan_id' ";
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
				$txtSearchCriteria = $txtSearchCriteria."  AND b.rekananshipping_line = '$rekananshipping_line' ";
			}
		}
		if($acc_id <> 0 )
		{
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = "b.acc_id = '$acc_id' ";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND  b.acc_id = '$acc_id' ";
			}
		} 
		if($startdate != '' && $enddate != '')
		{
			if($txtSearchCriteria == '')
			{ 
				$txtSearchCriteria = "(B.jurnal_bookdate >= '$startdate' and B.jurnal_bookdate =< '$enddate')"; 
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND (B.jurnal_bookdate >= '$startdate' and B.jurnal_bookdate <= '$enddate') ";
			}
		}
		
		$criteria=$txtSearchCriteria;
		// echo var_dump($criteria);exit;
		
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
		 
		$data['result'] = $this->model_receipt->get_ReportReceipt($channel_id,$criteria );
		//echo count($data['result']); //exit;
		$reportView = 'rpt_receipt/report_receipt'; 
		$data['title'] = 'Receipt Journal'; 
		$this->load->view($reportView,$data);
		
    }
	
	function report_excel(){

        $this->load->library("Excel/PHPExcel");
		PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );
		
		$channel_id = $this->session->userdata('channel_id'); 
		$criteria = $this->session->userdata('criteria'); 
					
        $prof = $this->model_receipt->get_ReportReceipt($channel_id,$criteria );
		 
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
		
        $objPHPExcel->getActiveSheet()->mergeCells('A1:P1');        
        $objPHPExcel->getActiveSheet()->mergeCells('A2:P2');        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A1", $tRegion);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A2", "Receipt Journal Tanggal ".strtoupper(getIndoHari(date('Y-m-d'))) );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A3", "TOTAL ROW(S) ".number_format(count($prof),0,',','.'));
		$objPHPExcel->setActiveSheetIndex(0)->getStyle("A1:P1")->applyFromArray($stylehURUF);
		$objPHPExcel->setActiveSheetIndex(0)->getStyle("A2:P2")->applyFromArray($stylehURUF);
        
        // auto fit column to content
        foreach(range('A','P') as $columnID) {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
          ->setAutoSize(true);
        }
        // set the names of header cells
        $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue("A4",'ID')
          ->setCellValue("B4",'Book Date')
          ->setCellValue("C4",'B.U')
          ->setCellValue("D4",'Store')
          ->setCellValue("E4",'Debtor')
          ->setCellValue("F4",'Tenant')
          ->setCellValue("G4",'Brand')
          ->setCellValue("H4",'Trx')
          ->setCellValue("I4",'IDR')
          ->setCellValue("J4",'IDR Inv')
          ->setCellValue("K4",'Journal Invoice') 
          ->setCellValue("L4",'Invoice.ID')
          ->setCellValue("M4",'Invoice Date')
          ->setCellValue("N4",'Faktur')
          ->setCellValue("O4",'Type')
          ->setCellValue("P4",'Corporate');

        $objPHPExcel->getActiveSheet()->getStyle('A4:P4')->applyFromArray($styleArray);

        // Add some data
        $x= 5;
        $y= 5;        
	
        foreach($prof as $sub){
			 
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue("A$x",$sub->jurnal_id)
          ->setCellValue("B$x",$sub->jurnal_bookdate)
          ->setCellValue("C$x",$sub->region_name)
          ->setCellValue("D$x",$sub->branch_name)
          ->setCellValue("E$x",$sub->debtor_no)
          ->setCellValue("F$x",$sub->rekanan_name)
          ->setCellValue("G$x",$sub->rekananshipping_name)
          ->setCellValue("H$x",$sub->agreementtype_nameshort)
          ->setCellValue("I$x",$sub->jurnaldetil_idr)
          ->setCellValue("J$x",$sub->INV_IDR)
          ->setCellValue("K$x",$sub->invoice_jurnal)
          ->setCellValue("L$x",$sub->invoice_id)
          ->setCellValue("M$x",$sub->invoice_date)
          ->setCellValue("N$x",$sub->faktur_id)
          ->setCellValue("O$x",$sub->OR_TYPE)
          ->setCellValue("P$x",$sub->c_status); 
		  
		  $objPHPExcel->getActiveSheet()->getStyle("B$x")
					->getNumberFormat()
					->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
		  $objPHPExcel->getActiveSheet()->getStyle("M$x")
					->getNumberFormat()
					->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$x++;
		//$y = $x;
        }

        $objPHPExcel->getActiveSheet(0)->setCellValue("H$x", 'Total');  
        $objPHPExcel->getActiveSheet(0)->setCellValue("I$x","=SUM(I$y:I".($x-1).")"); 
        $objPHPExcel->getActiveSheet(0)->setCellValue("J$x","=SUM(J$y:J".($x-1).")"); 
		 
		
        $objPHPExcel->getActiveSheet(0)->getStyle("I$x")->getFont()->setBold(true);  
        $objPHPExcel->getActiveSheet(0)->getStyle("J$x")->getFont()->setBold(true);  
        $objPHPExcel->getActiveSheet(0)->getStyle("A5:P$x")->applyFromArray($styleBody); 
        // $objPHPExcel->getActiveSheet(0)->getStyle("B5:B$x")->getNumberFormat()->setFormatCode('yyyy-mm-dd');
		
        // $objPHPExcel->getActiveSheet(0)->getStyle("L5:L$x")->getNumberFormat()->setFormatCode('yyyy-mm-dd');
        $objPHPExcel->getActiveSheet(0)->getStyle("I5:I$x")->getNumberFormat()->setFormatCode('#,##0.00');  
        $objPHPExcel->getActiveSheet(0)->getStyle("J5:J$x")->getNumberFormat()->setFormatCode('#,##0.00');  
        $objPHPExcel->getActiveSheet(0)->setTitle('Receipt Journal');

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
        header('Content-Disposition: attachment;filename="ReceiptJournal_'.date("Y-m-d").'.xlsx"');
        //unduh file
        $objWriter->save("php://output"); 
        exit; 
    }
	
	
	function branch_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_receipt->get_branch_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function acc_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_receipt->get_acc_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function region_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_receipt->get_region_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function rekanan_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_receipt->get_rekanan_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function rekananshipping_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_receipt->get_rekananshipping_dlg($rSearch['term']);
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