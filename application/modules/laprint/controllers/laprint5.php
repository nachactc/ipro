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
        
        $vsc=$this->model_laprint5->getservicecharge($loo_id);
        $vhargasc=$vsc['servicecharge'];
        
        $vpl=$this->model_laprint5->getloodesc($loo_id);
        $vloodes=$vpl['loo_descr'];
        
        $dps=$this->model_laprint5->getdepositr($loo_id);
        $vdps=$dps['depositr'];
 
        $data   = array(
                  'result'        => $this->model_laprint5->get_header($loo_id),
                  'schedule'      => $this->model_laprint5->get_schedule($loo_id),
				          'ritem'         => $this->model_laprint5->getitemagreement($loo_id),
                  'loo_id'        => $loo_id,
                  'vunit'         => $this->model_laprint5->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_laprint5->gethargasewa($loo_id),
                  'vhargasc'      => $vhargasc,
                  'vloodes'       => $vloodes,
                  'vdps'          => $vdps
                  
               );

        /** FORMULA UNTUK MEMBUAT CROSTAB TAB TAB**/
        $x_row        = array();
        $y_col        = array();
        $zcross_tab   = array();
        $xTotal       = array();
        $yTotal       = array();

        foreach($data['schedule'] as $sched){        

            $x_row[$sched->schedulepaymentdetil_date][] = $sched->schedulepaymentdetil_amount;
            $y_col[$sched->agreementtype_name][] = $sched->schedulepaymentdetil_amount;
            $zcross_tab[$sched->agreementtype_name.'_'.$sched->schedulepaymentdetil_date] = $sched->schedulepaymentdetil_amount;
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
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        
    }   
	
	function printatmpdf(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_looprint->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_looprint->getloodesc($loo_id);
                $vloodes=$vpl['loo_descr'];
                
                $dps=$this->model_looprint->getdepositr($loo_id);
                $vdps=$dps['depositr'];
 
        $data   = array(
                  'result'    => $this->model_looprint->viewatmprint($loo_id),
				  'ritem' => $this->model_looprint->getitemagreementatm($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_looprint->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_looprint->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vloodes' =>$vloodes,
                  'vdps' =>$vdps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_looprint->sholdetilby_id($loo_id);    

        $html=$this->load->view('looprint/rptof_atm1', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptloo.pdf";
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        
        
    }  
	
	function printatm2pdf(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_looprint->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_looprint->getloodesc($loo_id);
                $vloodes=$vpl['loo_descr'];
                
                $dps=$this->model_looprint->getdepositr($loo_id);
                $vdps=$dps['depositr'];
 
        $data   = array(
                  'result'    => $this->model_looprint->viewatmprint($loo_id),
				  'ritem' => $this->model_looprint->getitemagreementatm($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_looprint->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_looprint->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vloodes' =>$vloodes,
                  'vdps' =>$vdps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_looprint->sholdetilby_id($loo_id);    

        $html=$this->load->view('looprint/rptof_atm2', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptloo.pdf";
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        
        
    }    
	
	function printatmpdfloo(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_looprint->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_looprint->getloodesc($loo_id);
                $vloodes=$vpl['loo_descr'];
                
                $dps=$this->model_looprint->getdepositr($loo_id);
                $vdps=$dps['depositr'];
 
        $data   = array(
                  'result'    => $this->model_looprint->viewatmprint($loo_id),
				  'ritem' => $this->model_looprint->getitemagreementatm($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_looprint->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_looprint->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vloodes' =>$vloodes,
                  'vdps' =>$vdps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_looprint->sholdetilby_id($loo_id);    

        $html=$this->load->view('looprint/rptof_atm1loo', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptloo.pdf";
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        
        
    }  
	
	function printatm2pdfloo(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_looprint->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_looprint->getloodesc($loo_id);
                $vloodes=$vpl['loo_descr'];
                
                $dps=$this->model_looprint->getdepositr($loo_id);
                $vdps=$dps['depositr'];
 
        $data   = array(
                  'result'    => $this->model_looprint->viewatmprint($loo_id),
				  'ritem' => $this->model_looprint->getitemagreementatm($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_looprint->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_looprint->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vloodes' =>$vloodes,
                  'vdps' =>$vdps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_looprint->sholdetilby_id($loo_id);    

        $html=$this->load->view('looprint/rptof_atm2loo', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptloo.pdf";
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        
        
    }
	
	function printbts(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_looprint->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_looprint->getloodesc($loo_id);
                $vloodes=$vpl['loo_descr'];
                
                $dps=$this->model_looprint->getdepositr($loo_id);
                $vdps=$dps['depositr'];
				
				
 
        $data   = array(
                  'result'    => $this->model_looprint->viewbtsprint($loo_id),
				  'ritem' => $this->model_looprint->getitemagreementatm($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_looprint->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_looprint->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vloodes' =>$vloodes,
                  'vdps' =>$vdps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_looprint->sholdetilby_id($loo_id);    
//$this->load->view('looprint/rptbts', $data);
       $html=$this->load->view('looprint/rptbts', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptloo.pdf";
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I"); 
       
    }    
	
	
}  