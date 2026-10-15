<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class proforma extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();

        $this->load->library('breadcrumbcomponent');
        
        $this->load->model('model_proforma');        
        //$this->load->model('model_smprint');

    }

    function index(){

      //$data['agreement'] = $this->model_proforma->get_agreement();

      //$this->view('content/phpexcel', $data);
      redirect('proforma/rProfo');
    }

    function prof_excel($region, $branch, $date){

        $this->load->library("Excel/PHPExcel");

        $prof = $this->model_proforma->get_agreement($region, $branch, $date);

        $tBranch = '';

        if (isset($prof)){
          $tBranch = $prof[0]['branch_namerpt'];
        }

        //membuat objek PHPExcel
        $objPHPExcel = new PHPExcel();

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

        $styleBody = array(              
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
          ),
        );

        $objPHPExcel->getActiveSheet()->mergeCells('A1:J1');        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A1", $tBranch.' PROFORMA INVOICE');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A2", $date);

        
        // auto fit column to content
        foreach(range('A','J') as $columnID) {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
          ->setAutoSize(true);
        }
        // set the names of header cells
        $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue("A4",'Agreement')
          ->setCellValue("B4",'UNIT')
          ->setCellValue("C4",'ZONING/USES')
          ->setCellValue("D4",'NLA')
          ->setCellValue("E4",'RENTAL RATE')
          ->setCellValue("F4",'SERVICE CHARGE')
          ->setCellValue("G4",'RENTAL INCOME')
          ->setCellValue("H4",'SERVICE INCOME')
          ->setCellValue("I4",'ACTUAL INCOME')
          ->setCellValue("J4",'ACTUAL');

        $objPHPExcel->getActiveSheet()->getStyle('A4:J4')->applyFromArray($styleArray);

        // Add some data
        $x= 5;
        $y= 5;       
        $uType = '';
        $xArea = 0;
        $xRental = 0;
        $xService = 0;
        $xActualInc = 0;        

        foreach($prof as $sub){

          if ($x == 5 || $uType != $sub['rekananshipping_type']){

            if ($x != 5){
              $objPHPExcel->getActiveSheet(0)->setCellValue("C$x", 'Total');
              $objPHPExcel->getActiveSheet(0)->setCellValue("D$x","=SUM(D$y:D".($x-1).")");
              $objPHPExcel->getActiveSheet(0)->setCellValue("E$x","=G$x/D$x");
              $objPHPExcel->getActiveSheet(0)->setCellValue("F$x","=H$x/D$x");            
              $objPHPExcel->getActiveSheet(0)->setCellValue("G$x","=SUM(G$y:G".($x-1).")");              
              $objPHPExcel->getActiveSheet(0)->setCellValue("H$x","=SUM(H$y:H".($x-1).")");
              $objPHPExcel->getActiveSheet(0)->setCellValue("I$x","=SUM(I$y:I".($x-1).")");
              $objPHPExcel->getActiveSheet(0)->setCellValue("J$x","=I$x/D$x");

              $objPHPExcel->getActiveSheet(0)->getStyle("C$x:J$x")->getFont()->setBold(true);

              $x++;
            }

            $objPHPExcel->getActiveSheet(0)->getStyle("A$x")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet(0)->mergeCells("A$x:H$x");
            $objPHPExcel->getActiveSheet(0)->setCellValue("A$x", $sub['rekananshipping_type']);

            $x++;
            $y = $x;
          }

          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue("A$x",$sub['agreement_id'])
          ->setCellValue("B$x",$sub['agreementdetil_unit'])
          ->setCellValue("C$x",$sub['rekananshipping_name'])
          ->setCellValue("D$x",$sub['agreementdetil_space'])
          ->setCellValue("E$x",$sub['rental_rate'])
          ->setCellValue("F$x",$sub['service_charge'])
          ->setCellValue("G$x",$sub['rental_income'])
          ->setCellValue("H$x",$sub['service_income'])
          ->setCellValue("I$x","=G$x+H$x")
          ->setCellValue("J$x","=I$x/D$x");
          $x++;         

          $xArea    += $sub['agreementdetil_space'];
          $xRental  += $sub['rental_income'];
          $xService += $sub['service_income'];
          $xActualInc += ($sub['rental_income']+$sub['service_income']);          

          $uType = $sub['rekananshipping_type'];

        }

        $objPHPExcel->getActiveSheet(0)->setCellValue("C$x", 'Total');
        $objPHPExcel->getActiveSheet(0)->setCellValue("D$x","=SUM(D$y:D".($x-1).")");
        $objPHPExcel->getActiveSheet(0)->setCellValue("E$x","=G$x/D$x");
        $objPHPExcel->getActiveSheet(0)->setCellValue("F$x","=H$x/D$x");
        $objPHPExcel->getActiveSheet(0)->setCellValue("G$x","=SUM(G$y:G".($x-1).")");
        $objPHPExcel->getActiveSheet(0)->setCellValue("H$x","=SUM(H$y:H".($x-1).")");
        $objPHPExcel->getActiveSheet(0)->setCellValue("I$x","=SUM(I$y:I".($x-1).")");
        $objPHPExcel->getActiveSheet(0)->setCellValue("J$x","=I$x/D$x");

        $objPHPExcel->getActiveSheet(0)->getStyle("C$x:J$x")->getFont()->setBold(true);

        $x += 2;
       
        $objPHPExcel->getActiveSheet(0)->setCellValue("C$x", 'Grand Total');
        $objPHPExcel->getActiveSheet(0)->setCellValue("D$x", $xArea);
        $objPHPExcel->getActiveSheet(0)->setCellValue("E$x","=G$x/D$x");
        $objPHPExcel->getActiveSheet(0)->setCellValue("F$x","=H$x/D$x");
        $objPHPExcel->getActiveSheet(0)->setCellValue("G$x", $xRental);
        $objPHPExcel->getActiveSheet(0)->setCellValue("H$x", $xService);
        $objPHPExcel->getActiveSheet(0)->setCellValue("I$x", $xActualInc);
        $objPHPExcel->getActiveSheet(0)->setCellValue("J$x","=I$x/D$x");

        $objPHPExcel->getActiveSheet(0)->getStyle("C$x:J$x")->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet(0)->getStyle("A5:J$x")->applyFromArray($styleBody);

        $objPHPExcel->getActiveSheet(0)->getStyle("D6:J$x")->getNumberFormat()->setFormatCode('#,##0.00');


        $objPHPExcel->getActiveSheet(0)->setTitle('Sheet1');

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
        header('Content-Disposition: attachment;filename="proforma_inv_'.date("Y-m-d").'.xlsx"');
        //unduh file
        $objWriter->save("php://output");
        exit;

    }
	
    function rProfo(){ 

      $btload = $this->input->post('btload');

      if (isset($btload)){
        $_region    = $this->input->post('cboregion'); 
        $_branch    = $this->input->post('cbobranch');
        $_date      = $this->input->post('prof_date');
        $_type      = $this->input->post('itype');
        //$vsemester    = $rowsemester['semester_name'];

        switch ($_type) {
            case "detil":
              
              $this->prof_excel($_region, $_branch, $_date);
              break;
            case "summary":

              $this->prof_summ($_region, $_branch, $_date);
              break;

            default:
              //tes;

        }
        
      }else{
        $cbsemester = ""; 
        $cboyear    = "";
        $vsemester  = "";
      }

      $data=array(
        //'cbregion'  => $this->model_proforma->get_region(),
        'region'    => $this->region_select()
      ); 

      $this->breadcrumbcomponent->add('PROFORMA INCOME REPORT','proforma/proforma/rProfo');
      $this->load->view('template/v_header');                         
      $this->load->view('proforma/rpt_proforma',$data);
      $this->load->view('template/v_footer');

    } 

    function region_select(){
        $this->load->model('template/Master_m');
        
        $region     = $this->Master_m->get_region();

        if(count($region)){
            foreach($region as $key => $value){
                $options[$value->region_id]= $value->region_name;
            }
        }
                    
        return $options;
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


    function prof_summ($region, $branch, $date){

        $this->load->library("Excel/PHPExcel");

        $summary = $this->model_proforma->get_summary($region, $branch, $date);

        $service = $this->model_proforma->get_servicesum($region, $branch, $date);

        $tBranch = '';

        if (isset($summary)){
          $tBranch = $summary[0]['branch_namerpt'];
        }

        //membuat objek PHPExcel
        $objPHPExcel = new PHPExcel();

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
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
          ),
        );

        $styleBody = array(              
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
          ),
        );      


        $objPHPExcel->getActiveSheet()->mergeCells('F1:J2');        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F1", $tBranch);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle("F1:J2")->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)        
        ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // auto fit column to content
        foreach(range('A','K') as $columnID) {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
          ->setAutoSize(true);
        } 

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells("I3:J3");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("I3", "INCOME (x1000)");
        $objPHPExcel->setActiveSheetIndex(0)->getStyle("I3:J3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);      

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells("F3:G3");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F3", "AVG RATE");
        $objPHPExcel->setActiveSheetIndex(0)->getStyle("F3:G3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        

        // set the names of header cells
        $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue("A4",'NO')
          ->setCellValue("B4",'DESCRIPTION')          
          ->setCellValue("C4",'NLA')
          ->setCellValue("D4",'OCC')
          ->setCellValue("E4",'%')
          ->setCellValue("F4",'ACTUAL')
          ->setCellValue("G4",'TARGET')
          ->setCellValue("H4",'%')
          ->setCellValue("I4",'ACTUAL')
          ->setCellValue("J4",'TARGET')
          ->setCellValue("K4",'%');


        $objPHPExcel->getActiveSheet()->getStyle('A3:K4')->applyFromArray($styleArray);

        $x= 5;
        $y= 1;       

        foreach($summary as $val){         

          $objPHPExcel->setActiveSheetIndex(0)          
          ->setCellValue("A$x", $y)
          ->setCellValue("B$x", $val['rekananshipping_type'])
          ->setCellValue("C$x", $val['total_area'])
          ->setCellValue("D$x", $val['total_area'])
          ->setCellValue("E$x", "=IFERROR(D$x/C$x,0)")
          ->setCellValue("F$x", "=IFERROR(I$x/D$x,0)")
          ->setCellValue("G$x", "0")
          ->setCellValue("H$x", "0")
          ->setCellValue("I$x", $val['rental_income']/1000)
          ->setCellValue("J$x", "0")
          ->setCellValue("K$x", "0");
          $x++;       
          $y++;          

        }

        $objPHPExcel->getActiveSheet(0)->setCellValue("B$x", 'Subtotal');
        $objPHPExcel->getActiveSheet(0)->setCellValue("C$x","=SUM(C$y:C".($x-1).")");
        $objPHPExcel->getActiveSheet(0)->setCellValue("D$x","=SUM(D$y:D".($x-1).")");
        $objPHPExcel->getActiveSheet(0)->setCellValue("E$x", "=IFERROR(D$x/C$x,0)");
        $objPHPExcel->getActiveSheet(0)->setCellValue("F$x", "=IFERROR(I$x/D$x,0)");
        $objPHPExcel->getActiveSheet(0)->setCellValue("I$x","=SUM(I$y:I".($x-1).")");
        $objPHPExcel->getActiveSheet(0)->getStyle("B$x:K$x")->getFont()->setBold(true);

        $_inc = $x;

        $x++;
        //$y++;
        $objPHPExcel->getActiveSheet(0)
        ->setCellValue("A$x", $y)
        ->setCellValue("B$x", $service[0]['rekananshipping_type'])
        ->setCellValue("C$x", $service[0]['total_area'])
        ->setCellValue("D$x", $service[0]['total_area'])
        ->setCellValue("E$x", "=IFERROR(D$x/C$x,0)")
        ->setCellValue("F$x", "=IFERROR(I$x/D$x,0)")
        ->setCellValue("G$x", "0")
        ->setCellValue("H$x", "0")
        ->setCellValue("I$x", $service[0]['service_income']/1000)
        ->setCellValue("J$x", "0")
        ->setCellValue("K$x", "0");
        $_svc = $x;

        $x++;
        $objPHPExcel->getActiveSheet(0)->setCellValue("B$x", 'Total');
        $objPHPExcel->getActiveSheet(0)->setCellValue("C$x","=C$_inc");
        $objPHPExcel->getActiveSheet(0)->setCellValue("D$x","=D$_inc");
        $objPHPExcel->getActiveSheet(0)->setCellValue("E$x", "=IFERROR(D$x/C$x,0)");
        $objPHPExcel->getActiveSheet(0)->setCellValue("F$x", "=IFERROR(I$x/D$x,0)");
        $objPHPExcel->getActiveSheet(0)->setCellValue("I$x","=I$_inc+I$_svc");
        $objPHPExcel->getActiveSheet(0)->getStyle("B$x:K$x")->getFont()->setBold(true);

        
        $objPHPExcel->getActiveSheet(0)->getStyle("C5:K$x")->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->getActiveSheet(0)->getStyle("A5:K$x")->applyFromArray($styleBody);

        $objPHPExcel->getActiveSheet(0)->setTitle('Sheet1');

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
        header('Content-Disposition: attachment;filename="proforma_summ_'.date("Y-m-d").'.xlsx"');
        //unduh file
        $objWriter->save("php://output");
        exit;

    }
}  