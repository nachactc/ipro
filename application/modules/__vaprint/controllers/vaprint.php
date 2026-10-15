<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vaprint extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_vaprint');


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
	
      function vaprintpdf(){     
          $i_link = $this->uri->segment(4);       
          $loo_id = str_replace('_', '/', $i_link); 
          
        $shiping  =$this->model_vaprint->getmastershippingarray($loo_id);
        $rekanan_id =$shiping['rekanan_id']; 
		$rekananshipping_line =$shiping['rekananshipping_line']; 
        $branch_id =$shiping['branch_id']; 
		
		$regionbranch  =$this->model_vaprint->getmasterregionbranch_byid($branch_id);
        $region_id =$regionbranch['region_id'];
		
		$namesetting  =$this->model_vaprint->getmastersetting('rptVA_name');
        $name =$namesetting['setting_value']; 	
        $positionsetting  =$this->model_vaprint->getmastersetting('rptVA_position');
        $position =$positionsetting['setting_value'];		
		
		$lokasisurat  =$this->model_vaprint->getmastersetting('Lokasi_surat');
        $lokasi =$lokasisurat['setting_value'];	
		
		$va_utilities_listrik =0;
		$va_utilities_air =0;
		$va_utilities_gas =0;
		$va_levy =0;
		$va_fitout =0;
		$va_outlet =0;
					
		$rental  =$this->model_vaprint->getVAperagrtype($rekanan_id,$rekananshipping_line,'4000');
		$va_rental =$rental['VA']; 
		$sc  =$this->model_vaprint->getVAperagrtype($rekanan_id,$rekananshipping_line,'5000');
		$va_sc =$sc['VA']; 	
		$utilities  =$this->model_vaprint->getVAperagrtype($rekanan_id,$rekananshipping_line,'9997');
		$va_utilities =$utilities['VA'];	
		
		$utilitieslistrik  =$this->model_vaprint->getVAperagrtype($rekanan_id,$rekananshipping_line,'9997');
		$va_utilities_listrik =$utilitieslistrik['VA'];	
		
		$utilitiesair  =$this->model_vaprint->getVAperagrtype($rekanan_id,$rekananshipping_line,'9400');
		$va_utilities_air =$utilitiesair['VA'];	
		
		$utilitiesgas  =$this->model_vaprint->getVAperagrtype($rekanan_id,$rekananshipping_line,'9300');
		$va_utilities_gas =$utilitiesgas['VA'];	
		
		$levy  =$this->model_vaprint->getVAperagrtype($rekanan_id,$rekananshipping_line,'6500');
		$va_levy =$levy['VA'];	
		
		$fitout  =$this->model_vaprint->getVAperagrtype($rekanan_id,$rekananshipping_line,'11500');
		$va_fitout =$fitout['VA'];	
		
		$outlet  =$this->model_vaprint->getVAperagrtype($rekanan_id,$rekananshipping_line,'20000');
		$va_outlet =$outlet['VA'];
		
		
		$dp  =$this->model_vaprint->getVAperagrtype($rekanan_id,$rekananshipping_line,'1000');
		$va_dp =$dp['VA'];
		$deposit  =$this->model_vaprint->getVAperagrtype($rekanan_id,$rekananshipping_line,'7000');
		$va_deposit =$deposit['VA'];		
          $data   = array(
                    'result'    => $this->model_vaprint->get_rekananshipping($loo_id),
					'name' => $name,
					'position' => $position,
					'va_rental' => $va_rental,
					'va_sc' => $va_sc,
					'va_utilities' => $va_utilities,
					'va_dp' => $va_dp,
					'va_deposit' => $va_deposit,
					
					'va_utilities_listrik' => $va_utilities_listrik,
					'va_utilities_air' => $va_utilities_air,
					'va_utilities_gas' => $va_utilities_gas,
					'va_levy' => $va_levy,
					'va_fitout' => $va_fitout,
					'va_outlet' => $va_outlet,
					'lokasi' => $lokasi
            
         );                
        

        //$data['resultd'] = $this->model_vaprint->sholdetilby_id($loo_id);    

		// print_r($data);
		// exit;
		//$html=$this->load->view('vaprint/rptva', $data);
		if ($branch_id =='0000615'){
			$html=$this->load->view('vaprint/rptvatpp', $data,TRUE);
		}
		elseif ($region_id == '001'){
			$html=$this->load->view('vaprint/rptvatcp', $data,TRUE);
		}
		else
		{
			$html=$this->load->view('vaprint/rptva', $data,TRUE);
		}
		
        //$html=$this->load->view('vaprint/rptva', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptva.pdf";
		$this->m_pdf->pdf->SetHTMLHeader('<table width="100%"><tr><td align="right" style="font-size:10px"></td></tr></table>');
		$this->m_pdf->pdf->AddPage('P','A4','','','',20,20,20,20,15,0);
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        
        
    }   

    function invprintpdf(){     

        $i_link = $this->uri->segment(4);       
        $loo_id = str_replace('_', '/', $i_link); 


        $print_name = $this->session->userdata('user_fullname');

        $_dp  =$this->model_vaprint->getdepe($loo_id);
        $v_dp =$_dp['dp'];        
        
        $data   = array(
                  'result'      => $this->model_vaprint->viewinvprint($loo_id),
                  'print_name'  => $print_name                  
               );                

//$this->load->view('vaprintcasual/rptinpro', $data);
        $html=$this->load->view('vaprintcasual/rptinpro', $data, TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptinpro.pdf";

		ob_clean();
        $this->m_pdf->pdf->AddPage('P','','','','',2,2,5,5,20,0);
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I"); 

    } 
	
	function printatmpdf(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_vaprint->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_vaprint->getloodesc($loo_id);
                $vloodes=$vpl['loo_descr'];
                
                $dps=$this->model_vaprint->getdepositr($loo_id);
                $vdps=$dps['depositr'];
 
        $data   = array(
                  'result'    => $this->model_vaprint->viewatmprint($loo_id),
				  'ritem' => $this->model_vaprint->getitemagreementatm($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_vaprint->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_vaprint->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vloodes' =>$vloodes,
                  'vdps' =>$vdps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_vaprint->sholdetilby_id($loo_id);    

        $html=$this->load->view('vaprint/rptof_atm1', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptloo.pdf";
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        
        
    }  
	
	function printatm2pdf(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_vaprint->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_vaprint->getloodesc($loo_id);
                $vloodes=$vpl['loo_descr'];
                
                $dps=$this->model_vaprint->getdepositr($loo_id);
                $vdps=$dps['depositr'];
 
        $data   = array(
                  'result'    => $this->model_vaprint->viewatmprint($loo_id),
				  'ritem' => $this->model_vaprint->getitemagreementatm($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_vaprint->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_vaprint->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vloodes' =>$vloodes,
                  'vdps' =>$vdps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_vaprint->sholdetilby_id($loo_id);    

        $html=$this->load->view('vaprint/rptof_atm2', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptloo.pdf";
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        
        
    }    
	
	function printatmpdfloo(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_vaprint->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_vaprint->getloodesc($loo_id);
                $vloodes=$vpl['loo_descr'];
                
                $dps=$this->model_vaprint->getdepositr($loo_id);
                $vdps=$dps['depositr'];
 
        $data   = array(
                  'result'    => $this->model_vaprint->viewatmprint($loo_id),
				  'ritem' => $this->model_vaprint->getitemagreementatm($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_vaprint->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_vaprint->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vloodes' =>$vloodes,
                  'vdps' =>$vdps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_vaprint->sholdetilby_id($loo_id);    

        $html=$this->load->view('vaprint/rptof_atm1loo', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptloo.pdf";
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        
        
    }  
	
	function printatm2pdfloo(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_vaprint->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_vaprint->getloodesc($loo_id);
                $vloodes=$vpl['loo_descr'];
                
                $dps=$this->model_vaprint->getdepositr($loo_id);
                $vdps=$dps['depositr'];
 
        $data   = array(
                  'result'    => $this->model_vaprint->viewatmprint($loo_id),
				  'ritem' => $this->model_vaprint->getitemagreementatm($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_vaprint->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_vaprint->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vloodes' =>$vloodes,
                  'vdps' =>$vdps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_vaprint->sholdetilby_id($loo_id);    

        $html=$this->load->view('vaprint/rptof_atm2loo', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptloo.pdf";
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        
        
    }
	
	function printbts(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_vaprint->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_vaprint->getloodesc($loo_id);
                $vloodes=$vpl['loo_descr'];
                
                $dps=$this->model_vaprint->getdepositr($loo_id);
                $vdps=$dps['depositr'];
				
				
 
        $data   = array(
                  'result'    => $this->model_vaprint->viewbtsprint($loo_id),
				  'ritem' => $this->model_vaprint->getitemagreementatm($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_vaprint->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_vaprint->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vloodes' =>$vloodes,
                  'vdps' =>$vdps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_vaprint->sholdetilby_id($loo_id);    
//$this->load->view('vaprint/rptbts', $data);
       $html=$this->load->view('vaprint/rptbts', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptloo.pdf";
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I"); 
       
    }    
	
	
}  