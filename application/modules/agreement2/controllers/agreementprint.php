<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agreementprint extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_agreementprint');

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


        if (is_array($rSearch) && $rSearch['_type'] == 'query'){            

            $this->load->model('template/Master_m');
            
            $branch      = $this->Master_m->get_branchbyquery($rSearch['term']);
            
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
	
    function print_pdf(){     

        $_id = $this->uri->segment(4);
                
        $ang=$this->model_agreementprint->getangsuran($_id);        

        $max_ang = (max($ang));

        $vang=$max_ang['angsuran'];      
 
        $data   = array(
                  'result'        => $this->model_agreementprint->get_header($_id),
                  'schedule'      => $this->model_agreementprint->get_schedule($_id),				         
                  'vunit'         => $this->model_agreementprint->getunit($_id),
                  'vhargasewa'    => $this->model_agreementprint->gethargasewa($_id),
                  'vhargapromo'   => $this->model_agreementprint->gethargapromo($_id),
                  'vhargafood'    => $this->model_agreementprint->gethargafoodcourt($_id),
                  'vhargasc'      => $this->model_agreementprint->getservicecharge($_id),
                  'vtotallease'   => $this->model_agreementprint->gettotallease($_id),
                  'vang'          => $vang,
                  'vdepe'         => $this->model_agreementprint->getdepe($_id),
                  'vdeposit'      => $this->model_agreementprint->getdeposit($_id),
                  'vtdep'         => $this->model_agreementprint->gettdep($_id),                  
                  'vruangsewa'    => $this->model_agreementprint->get_ruang($_id)
                  
               );

        /** FORMULA UNTUK MEMBUAT CROSTAB TAB TAB**/
        $x_row        = array();
        $y_col        = array();
        $zcross_tab   = array();
        $xTotal       = array();
        $yTotal       = array();

        //print_r($data['schedule']); exit;

        foreach($data['schedule'] as $sched){  

            $_startdate = date_create($sched->agreement_startdate);           
            $interval = new DateInterval('P12M');

            $_startdate->add($interval);
            $_startdate->modify('first day of this month');;
           
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
        $data['region']       = $this->region_select();
        $data['branch']       = $this->branch_select();   
        $data['agrtype']      = $this->agrtype_select();        

        //$this->load->view('agreement/rpt_agreement', $data); exit;

        $html=$this->load->view('agreement/rpt_agreement', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "agreement.pdf";

        $this->m_pdf->pdf->simpleTables = true;

        $this->m_pdf->pdf->packTableData = true;

        $this->m_pdf->pdf->AddPage('P','','','','',30,10,25,15,8,8);
        $this->m_pdf->pdf->WriteHTML($html);       
        $this->m_pdf->pdf->Output($pdfFilePath, "I");

    }
		
}  