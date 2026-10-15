<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jurnalsummary extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        check_user_login();
        $this->load->library('breadcrumbcomponent');
        $this->load->model('model_jurnalsummary'); 
	   
    }

    function index(){
      redirect('jurnalsummary/pgsummary');
    }
	
    function pgsummary(){ 

      $btload = $this->input->post('btload');
      if (isset($btload)){
        $_region    = $this->input->post('cboregion'); 
        $_branch    = $this->input->post('cbobranch');
        $_date      = $this->input->post('prof_date');
        $_type      = $this->input->post('itype');
        //$vsemester    = $rowsemester['semester_name'];

      
        
      }else{
        $cbsemester = ""; 
        $cboyear    = "";
        $vsemester  = "";
      }

      $data=array(
        //'cbregion'  => $this->model_proforma->get_region(),
        'region'    => $this->region_select(),
		'acc'    => $this->account_select()
      ); 

      $this->breadcrumbcomponent->add('Trial Balance','proforma/proforma/rProfo');
      $this->load->view('template/v_header');                         
      $this->load->view('jurnalsummary/rpt_jurnalsummary',$data);
      $this->load->view('template/v_footer');

    } 
function printsummary(){
	
	$btload = $this->input->post('btload');
      if (isset($btload)){
        $_region    = $this->input->post('cboregion'); 
        $_cboacc    = $this->input->post('cboacc');
        $_date      = $this->input->post('sumary_date');
        $_type      = $this->input->post('itype');
		
		
		
		  switch ($_type) {
            case "detilregionbln":
			 $data=array(
        			'jsumbul_reg' => $this->model_jurnalsummary->getspdetilbulananregion($_date,$_cboacc),
					 'jdetsumreg_loop' => $this->model_jurnalsummary->getspdetilbulananregionloop($_date,$_cboacc),
					'tgl'=> $_date,
					'cboacc'=>$_cboacc  
      			); 
              
              $this->load->view('jurnalsummary/rptbulanandet_region',$data);
              break;
            case "sumaryregionbln":  
			 $data=array(
        'jsumbul_reg'    => $this->model_jurnalsummary->getspsumarybulananregion($_date,$_cboacc),
		'tgl'=> $_date,
		'cboacc'=>$_cboacc  
      );          
			  $this->load->view('jurnalsummary/rptbulanansum_region',$data);
              break;

            default:
              //tes;

        }
		
		
	  }
	
}
 function account_select(){
       // $this->load->model('model_jurnalsummary');
        
        $acc= $this->model_jurnalsummary->get_acc();

        if(count($acc)){
			$options[""]="--Pilih--";
            foreach($acc as $key => $value){
                $options[$value->acc_id]= $value->vacc_name;
            }
        }
                    
        return $options;
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