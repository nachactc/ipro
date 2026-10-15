<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ivp extends CI_Controller{
    
  function __construct(){
      
      parent::__construct();        
      // Check login and make sure email has been verified
      check_user_login();
      $this->load->library('table');
      $this->load->model('model_ivp');
      $this->load->library('breadcrumbcomponent');
      $this->load->helper(array('form', 'url'));
  }    	
	
	function index(){       
      redirect('ivp/ivp_list');
  }   		       	    

  function ivp_list(){
          
      $this->breadcrumbcomponent->add('Invoice vs Payment Report','ivp/ivp_list'); 
      //$data['agrType'] = $this->Agr_select();    
      //$data['region'] = $this->region_select();
      $this->load->view('template/v_header');
      $this->load->view('ivp/ivp_list');
      $this->load->view('template/v_footer');
  }
     	
   
  function report_load(){

      //$enddate = $this->input->post('enddate') != '' ? date('Y-m-d',strtotime($this->input->post('enddate'))) :  date('Y-m-d')  ;        
      $username = $this->session->userdata('username');
      
      $data['enddate'] = $enddate;
      //$data['result'] = $this->model_ivp->get_Data($enddate, $username);
      $reportView = 'ivp/ivp_report';
      $data['title'] = 'Invoice vs Payment Report';

      $this->load->view($reportView, $data);

  }			

  function report_result(){

      set_time_limit(1000);
      //$this->load->model('tops/Posts_model');
      //$date = isset($_POST['enddate']) ? $_POST['enddate'] : date("Y-m-d");
      $result = new \stdClass;

      try{

        $date = empty($_POST['enddate']) ? date('Y-m-d') : $_POST['enddate'];
        
        $username = $this->session->userdata('username');

        if ( $this->model_ivp->set_Data($date, $username) ){
           $result->status = true;
           $result->message = 'Success';
        };         

      } catch(Exception $ex) {

        $result->status = false;
        $result->message = $ex.getMessage();  
      }

      echo json_encode($result);
      //require(APPPATH."third_party/PHPExcel-1.8/Classes/PHPExcel.php");
      //require(APPPATH."third_party/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel5.php");

  }

  function export_csv(){

    set_time_limit(0);
    //$this->load->model('tops/Posts_model');
    //$date = isset($_POST['enddate']) ? $_POST['enddate'] : date("Y-m-d");
    $date = empty($_POST['enddate']) ? date('Y-m-d') : $_POST['enddate'];
    
    $username = $this->session->userdata('username');

    $records = array();

    $countRows = $this->model_ivp->get_Count($date, $username);     
    
    $count = 0;

    $count = ceil($countRows/10000);

    //header('Content-Type: application/vnd.ms-excel')
    $ivpData  = "doc_id;doc_type;doc_descr;doc_period;doc_date;doc_line;faktur_no;pro_id;pro_period;pro_date;";
    $ivpData  .= "region_id;region_name;branch_id;branch_name;rekanan_id;rekanan_name;rekananshipping_line;rekananshipping_name;";
    $ivpData  .= "contract_no;grouptenant_id;rekananshipping_isactive;agreementtype_groupcollection;due;AMOUNT;";
    $ivpData  .= "transaksi_type;Aging_type;salesarea_id;COLL_IDR;All_id;All_date;OR_id;OR_type;OR_period;";
    $ivpData  .= "OR_date;tenant_type;p_status;c_status;Aging\n";
    
    for ($i=0; $i<=$count; $i++) {
        # code...
        $start = ($i == 0) ? $i+1 : $end+1;
        $end = (($i+1) * 10000);

        $record = $this->model_ivp->get_Data($date, $username, $start, $end);

        //array_push($records, $record);
        foreach ($record as $key){          

            $ivpData .= $key['doc_id'].';'.$key['doc_type'].';'.str_replace(';','', $key['doc_descr']).';'.$key['doc_period'].';';
            $ivpData .= $key['doc_date'].';'.$key['doc_line'].';'.$key['faktur_no'].';'.$key['pro_id'].';';
            $ivpData .= $key['pro_period'].';'.$key['pro_date'].';'.$key['region_id'].';'.$key['region_name'].';';
            $ivpData .= $key['branch_id'].';'.$key['branch_name'].';'.$key['rekanan_id'].';'.$key['rekanan_name'].';';
            $ivpData .= $key['rekananshipping_line'].';'.$key['rekananshipping_name'].';'.$key['contract_no'].';'.$key['grouptenant_id'].';';
            $ivpData .= $key['rekananshipping_isactive'].';'.$key['agreementtype_groupcollection'].';'.$key['due'].';'.$key['AMOUNT'].';';
            $ivpData .= $key['transaksi_type'].';'.$key['Aging_type'].';'.$key['salesarea_id'].';'.$key['COLL_IDR'].';';
            $ivpData .= $key['All_id'].';'.$key['All_date'].';'.$key['OR_id'].';'.$key['OR_type'].';';
            $ivpData .= $key['OR_period'].';'.$key['OR_date'].';'.$key['tenant_type'].';'.$key['p_status'].';';
            $ivpData .= $key['c_status'].';'.$key['Aging']."\n";
        }

        //echo memory_get_usage() . "<br>\n";
        //echo memory_get_peak_usage() . "<br>\n";
        //unset($record);
    }    

    ob_start();

    $fp = fopen('php://output', 'wb');

    fwrite($fp, $ivpData);
    fclose($fp);

    $csvData = ob_get_contents();
    ob_end_clean();

    $result = array(
              'status' => true,            
              'file' => base64_encode($csvData)
            );

    die(json_encode($result));        

  }


  function export_result(){

    set_time_limit(0);
    //$this->load->model('tops/Posts_model');
    //$date = isset($_POST['enddate']) ? $_POST['enddate'] : date("Y-m-d");
    $date = empty($_POST['enddate']) ? date('Y-m-d') : $_POST['enddate'];
    
    $username = $this->session->userdata('username');

    $records = array();

    $countRows = $this->model_ivp->get_Count($date, $username);     
    
    $count = 0;

    $count = ceil($countRows/10000);

    $this->load->library("Excel/PHPExcel");

    $objPHPExcel = new PHPExcel();            

    $objPHPExcel->setActiveSheetIndex(0);

    $sheet = $objPHPExcel->getActiveSheet();

    $this->set_header_excel($sheet);      

    $row = 2;

    for ($i=0; $i<=$count; $i++) {
        # code...
        $start = ($i == 0) ? $i+1 : $end+1;
        $end = (($i+1) * 10000);

        $record = $this->model_ivp->get_Data($date, $username, $start, $end);

        //array_push($records, $record);
        foreach ($record as $key){          

            $sheet->setCellValue("A".$row, $key['doc_id']);
            $sheet->setCellValue("B".$row, $key['doc_type']);
            $sheet->setCellValue("C".$row, $key['doc_descr']);
            $sheet->setCellValue("D".$row, $key['doc_period']);
            $sheet->setCellValue("E".$row, PHPExcel_Shared_Date::PHPToExcel( date('Y-m-d', strtotime($key['doc_date']))));
            $sheet->getStyle("E".$row)->getNumberFormat()->setFormatCode('dd-mm-yyyy');
            $sheet->setCellValue("F".$row, $key['doc_line']);
            $sheet->setCellValue("G".$row, $key['faktur_no']);          
            $sheet->setCellValue("H".$row, $key['pro_id']);
            $sheet->setCellValue("I".$row, $key['pro_period']);
            $sheet->setCellValue("J".$row, PHPExcel_Shared_Date::PHPToExcel( date('Y-m-d', strtotime($key['pro_date']))));
            $sheet->getStyle("J".$row)->getNumberFormat()->setFormatCode('dd-mm-yyyy');
            $sheet->setCellValue("K".$row, $key['region_id']);
            $sheet->setCellValue("L".$row, $key['region_name']);
            $sheet->setCellValue("M".$row, $key['branch_id']);
            $sheet->setCellValue("N".$row, $key['branch_name']);
            $sheet->setCellValue("O".$row, $key['rekanan_id']);
            $sheet->setCellValue("P".$row, $key['rekanan_name']);
            $sheet->setCellValue("Q".$row, $key['rekananshipping_line']);
            $sheet->setCellValue("R".$row, $key['rekananshipping_name']);
            $sheet->setCellValue("S".$row, $key['contract_no']);
            $sheet->setCellValue("T".$row, $key['grouptenant_id']);
            $sheet->setCellValue("U".$row, $key['rekananshipping_isactive']);
            $sheet->setCellValue("V".$row, $key['agreementtype_groupcollection']);
            $sheet->setCellValue("W".$row, $key['due']);
            $sheet->setCellValue("X".$row, $key['AMOUNT']);
            $sheet->setCellValue("Y".$row, $key['transaksi_type']);
            $sheet->setCellValue("Z".$row, $key['Aging_type']);
            $sheet->setCellValue("AA".$row, $key['salesarea_id']);
            $sheet->setCellValue("AB".$row, $key['COLL_IDR']);
            $sheet->setCellValue("AC".$row, $key['All_id']);
            $sheet->setCellValue("AD".$row, PHPExcel_Shared_Date::PHPToExcel( date('Y-m-d', strtotime($key['All_date']))));
            $sheet->getStyle("AD".$row)->getNumberFormat()->setFormatCode('dd-mm-yyyy');          
            $sheet->setCellValue("AE".$row, $key['OR_id']);
            $sheet->setCellValue("AF".$row, $key['OR_type']);
            $sheet->setCellValue("AG".$row, $key['OR_period']);
            $sheet->setCellValue("AH".$row, PHPExcel_Shared_Date::PHPToExcel( date('Y-m-d', strtotime($key['OR_date']))));
            $sheet->getStyle("AH".$row)->getNumberFormat()->setFormatCode('dd-mm-yyyy');          
            $sheet->setCellValue("AI".$row, $key['tenant_type']);
            $sheet->setCellValue("AJ".$row, $key['p_status']);
            $sheet->setCellValue("AK".$row, $key['c_status']);
            $sheet->setCellValue("AL".$row, $key['Aging']);
            $row++;
        }

        echo memory_get_usage() . "<br>\n";
        echo memory_get_peak_usage() . "<br>\n";

        //unset($record);
    }    

      //$filename = "Invoice_vs_Payment-on-".$date.".xlsx";
      $sheet->setTitle("Invoice-vs-Payment");

      //header("Pragma: public");
      //header("Expires: 0");
      //header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      //header("Content-Type: application/force-download");
      //header("Content-Type: application/octet-stream");
      //header("Content-Type: application/download");;
      //header("Content-Disposition: attachment;filename=$filename");

      //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');          
      $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
      //force user to download the Excel file without writing it to server's HD
      ob_start();
      $objWriter->save('php://output');
      //set_time_limit(30);
      //exit;        
      $xlsData = ob_get_contents();
      ob_end_clean();

      $result = array(
            'status' => true,
            //'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
            'file' => base64_encode($xlsData)
        );

      die(json_encode($result));        
  }

  function set_header_excel($sheet){

      $sheet->setCellValue("A1","doc_id");
      $sheet->setCellValue("B1","doc_type");
      $sheet->setCellValue("C1","doc_descr");
      $sheet->setCellValue("D1","doc_period");
      $sheet->setCellValue("E1","doc_date");      
      $sheet->setCellValue("F1","doc_line");   
      $sheet->setCellValue("G1","faktur_no");   
      $sheet->setCellValue("H1","pro_id");   
      $sheet->setCellValue("I1","pro_period");   
      $sheet->setCellValue("J1","pro_date");   
      $sheet->setCellValue("K1","region_id");   
      $sheet->setCellValue("L1","region_name");   
      $sheet->setCellValue("M1","branch_id");   
      $sheet->setCellValue("N1","branch_name");   
      $sheet->setCellValue("O1","rekanan_id");   
      $sheet->setCellValue("P1","rekanan_name");
      $sheet->setCellValue("Q1","rekananshipping_line");
      $sheet->setCellValue("R1","rekananshipping_name");
      $sheet->setCellValue("S1","contract_no");
      $sheet->setCellValue("T1","grouptenant_id");
      $sheet->setCellValue("U1","rekananshipping_isactive");
      $sheet->setCellValue("V1","agreementtype_groupcollection");
      $sheet->setCellValue("W1","due");
      $sheet->setCellValue("X1","AMOUNT");
      $sheet->setCellValue("Y1","transaksi_type");
      $sheet->setCellValue("Z1","Aging_type");
      $sheet->setCellValue("AA1","salesarea_id");
      $sheet->setCellValue("AB1","COLL_IDR");
      $sheet->setCellValue("AC1","All_id");
      $sheet->setCellValue("AD1","All_date");
      $sheet->setCellValue("AE1","OR_id");
      $sheet->setCellValue("AF1","OR_type");
      $sheet->setCellValue("AG1","OR_period");
      $sheet->setCellValue("AH1","OR_date");
      $sheet->setCellValue("AI1","tenant_type");
      $sheet->setCellValue("AJ1","p_status");
      $sheet->setCellValue("AK1","c_status");
      $sheet->setCellValue("AL1","Aging");
  }

  function get_memory_limit(){

    $limit_string = ini_get('memory_limit');
    $unit = strtolower(mb_substr($limit_string, -1));
    $bytes = intval(mb_substr($limit_string, 0, -1), 10);

    switch ($unit){

      case 'k':
        $bytes *= 1024;
        break 1;
      case 'm':
        $bytes *= 1048576;
        break 1;
      case 'g':
        $bytes *= 1073741824;
        break 1;
      default:
        break 1;
    }

    return $bytes;
  }

}  