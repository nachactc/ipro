<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class laprint5 extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_laprint5');

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
	
    function laprint5pdf(){     
        $i_link = $this->uri->segment(4);       
        $loo_id = str_replace('_', '/', $i_link); 
        
        $vpl=$this->model_laprint5->getloodesc($loo_id);
        $vloodes=$vpl['loo_descr'];

        $ang=$this->model_laprint5->getangsuran($loo_id);

        $max_ang = (max($ang));

        $vang=$max_ang['angsuran'];

        $la_id = nola_header($loo_id);
 
        $data   = array(
                  'result'        => $this->model_laprint5->get_header($loo_id),
                  'schedule'      => $this->model_laprint5->get_schedule($loo_id),
				          //'ritem'         => $this->model_laprint5->getitemagreement($loo_id),
                  'loo_id'        => $loo_id,
                  'la_id'         => $la_id,
                  'vunit'         => $this->model_laprint5->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_laprint5->gethargasewa($loo_id),
                  'vhargapromo'   => $this->model_laprint5->gethargapromo($loo_id),
                  'vhargafood'    => $this->model_laprint5->gethargafoodcourt($loo_id),
                  'vhargasc'      => $this->model_laprint5->getservicecharge($loo_id),
                  'vtotallease'   => $this->model_laprint5->gettotallease($loo_id),
                  'vang'          => $vang,
                  'vdepe'         => $this->model_laprint5->getdepe($loo_id),
                  'vdeposit'      => $this->model_laprint5->getdeposit($loo_id),
                  'vtdep'         => $this->model_laprint5->gettdep($loo_id),
                  'vloodes'       => $vloodes,
                  'vruangsewa'    => $this->model_laprint5->get_ruang($loo_id)
                  
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
       // ECHO VAR_dump($data['schedule']);exit;
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

        $data['resultd'] = $this->model_laprint5->sholdetilby_id($loo_id);    
        //$this->load->view('laprint5/rptla5', $data);
		
		
        $html=$this->load->view('laprint5/rptla5', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "laprint5.pdf";

        $this->m_pdf->pdf->simpleTables = true;

        $this->m_pdf->pdf->packTableData = true;

        $this->m_pdf->pdf->AddPage('P','','','','',30,10,25,15,8,8);
        $this->m_pdf->pdf->WriteHTML($html);       
        $this->m_pdf->pdf->Output($pdfFilePath, "I");     


    }
  function laprint7pdf(){     
        
        $i_link = $this->uri->segment(4);       
        $loo_id = str_replace('_', '/', $i_link);         

        $la_id = nola_header($loo_id);      

        $data   = array(
                  'result'   => $this->model_laprint5->get_header7($loo_id),
                  'la_config' => $this->model_laprint5->get_laconfig($loo_id),
                  'la_id'    => $la_id
        );           

        //echo var_dump($data['result']);	exit;     
        //$data['resultd'] = $this->model_laprint5->sholdetilby_id($loo_id);    
        //$this->load->view('laprint5/rptla7', $data);
        $html=$this->load->view('laprint5/rptla7', $data,TRUE);
        $this->load->library('m_pdf');        
        $pdfFilePath = "laprint7.pdf";
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        
    }   
			
}  