<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Locprintbts extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_locprintbts');


    }
    
	
    function region_select(){
        $this->load->model('template/Master_m');
        
        $region     = $this->Master_m->get_region();
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
	
    function locprintpdf(){     
          $i_link = $this->uri->segment(4);       
          $loc_id = str_replace('_', '/', $i_link); 
          
          $vsc=$this->model_locprintbts->getservicecharge($loc_id);
          $vhargasc=$vsc['servicecharge'];
          
          $vpl=$this->model_locprintbts->getlocdesc($loc_id);
          $vlocdes=$vpl['loc_descr'];
          
          $dps=$this->model_locprintbts->getdepositr($loc_id);
          $vdps=$dps['depositr'];
          $dpsrsc=$this->model_locprintbts->getdepositrsc($loc_id);
          $vdpsrsc=$dpsrsc['depositrsc'];				
				
          $data   = array(
                'result'              => $this->model_locprintbts->viewlocprint($loc_id),
			          'ritem'               => $this->model_locprintbts->getitemagreement($loc_id),
                'loc_id'              => $loc_id,
                'vunit'               => $this->model_locprintbts->getunitloc($loc_id),
                'vhargasewa'          => $this->model_locprintbts->gethargasewa($loc_id),
                'vtelponidr'          => $this->model_locprintbts->gettelponidr($loc_id),
  				      'vtelpondeposit'      => $this->model_locprintbts->gettelpondeposit($loc_id),
  				      'vtelponinstal'       => $this->model_locprintbts->gettelponinstal($loc_id),
  				      'vdepositrsc'         => $vdpsrsc,				  
                'vhargasc'            => $vhargasc,
                'vlocdes'             => $vlocdes,
                'vdps'                => $vdps,
  				      'rgm'                 => $this->model_locprintbts->getwebsetting('2'),
  				      'rstaff'              => $this->model_locprintbts->getwebsetting('3')
          );                
        
          $data['region'] = $this->region_select();
          $data['branch'] = $this->branch_select();   
          $data['agrtype'] = $this->agrtype_select();

          $data['resultd'] = $this->model_locprintbts->sholdetilby_id($loc_id);    

          $html=$this->load->view('locprint/rptloc_bts', $data,TRUE);
          $this->load->library('m_pdf');
          $pdfFilePath = "rptloc_bts.pdf";
      		$this->m_pdf->pdf->SetHTMLHeader('<table width="100%"><tr><td align="right" style="font-size:10px">{PAGENO}/{nb}</td></tr></table>');
      		$this->m_pdf->pdf->AddPage('P','','','','',35,35,25,30,20,0);
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