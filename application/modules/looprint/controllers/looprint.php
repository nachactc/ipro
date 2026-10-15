<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Looprint extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_looprint');


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
	
	function olprintpdf(){     
          $i_link = $this->uri->segment(4);       
          $loo_id = str_replace('_', '/', $i_link); 
          
          $vsc=$this->model_looprint->getservicecharge($loo_id);
          $vhargasc=$vsc['servicecharge'];
          
          $vpl=$this->model_looprint->getloodesc($loo_id);
          $vloodes=$vpl['loo_descr'];
          
          $dps=$this->model_looprint->getdepositr($loo_id);
          $vdps=$dps['depositr'];
	

          $data   = array(
                    'result'    => $this->model_looprint->viewlooprint($loo_id),
  				    'ritem' => $this->model_looprint->getitemagreement($loo_id),
                    'loo_id'   => $loo_id,
                    'vunit'    => $this->model_looprint->getunitloo($loo_id),
                    'vhargasewa'    => $this->model_looprint->gethargasewa($loo_id),
                    'vhargasc' =>$vhargasc,
                    'vloodes' =>$vloodes,
                    'vdps' =>$vdps,
  				    'rgm' => $this->model_looprint->getwebsetting('2'),
  				    'rstaff' => $this->model_looprint->getwebsetting('3'), 
            
         );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_looprint->sholdetilby_id($loo_id);    
//$this->load->view('looprint/rptol', $data);
        $html=$this->load->view('looprint/rptol', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptol.pdf";
        //$this->m_pdf->pdf->SetFont('zaskiagothic');
		//$this->m_pdf->pdf->setFooter('{PAGENO}/{nbpg}');
		$this->m_pdf->pdf->SetHTMLHeader('<table width="100%"><tr><td align="left" style="font-size:10px">'.$loo_id.'</td></tr><tr><td align="left" style="font-size:10px">Page :{PAGENO}/{nb}</td></tr></table>');
		$this->m_pdf->pdf->AddPage('P','','','','',35,35,30,30,20,0);
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I"); 
        
        
    }  
	
	
    function looprintpdf(){     
          $i_link = $this->uri->segment(4);       
          $loo_id = str_replace('_', '/', $i_link); 
          
          $vsc=$this->model_looprint->getservicecharge($loo_id);
          $vhargasc=$vsc['servicecharge'];
		  if ($vhargasc>0){$vhargasc=$vhargasc;}else{$vhargasc=0;}
          
          $vpl=$this->model_looprint->getloodesc($loo_id);
          $vloodes=$vpl['loo_descr'];
          
          $dps=$this->model_looprint->getdepositr($loo_id);
          $vdps=$dps['depositr'];
		  
		  $rpromo=$this->model_looprint->getpromolevy($loo_id);
		  $vpromolevy=$dps['promolevy'];
		  if ($vpromolevy>0){$vpromolevy=$vpromolevy;}else{$vpromolevy=0;}
	

          $data   = array(
                    'result'    => $this->model_looprint->viewlooprint($loo_id),
  				    'ritem' => $this->model_looprint->getitemagreement($loo_id),
                    'loo_id'   => $loo_id,
                    'vunit'    => $this->model_looprint->getunitloo($loo_id),
                    'vhargasewa'    => $this->model_looprint->gethargasewa($loo_id),
                    'vhargasc' =>$vhargasc,
                    'vloodes' =>$vloodes,
                    'vdps' =>$vdps,
					'vpromolevy' =>$vpromolevy,
  				    'rgm' => $this->model_looprint->getwebsetting('2'),
  				    'rstaff' => $this->model_looprint->getwebsetting('3'),
					'resultdetil' => $this->model_looprint->viewlooprintdetil($loo_id),
            
         );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();
		
		$loo_tempid_val = array (
		'1'=>'ATM',
		'2'=>'F&B',
		'3'=>'FOOD COURT',
		'4'=>'JEWELLERY',
		'5'=>'SPECIALTY', 
		);
		$type_loo_tempid = $this->model_looprint->viewlooprint($loo_id,'object');
		// echo var_dump($loo_tempid_val[$type_loo_tempid->loo_tempid]);
		// exit;
		$val_temp_id = $loo_tempid_val[$type_loo_tempid->loo_tempid];
		$vpage='';
		switch ($val_temp_id) {
			case 'ATM':
				$vpage="";
				break;
			case 'F&B':
				$vpage="looprint/rptloo_fnb";
				break;
			case 'FOOD COURT':
				$vpage="looprint/rptloo_foodcourt";
				break; 
			case 'JEWELLERY':
				$vpage="";
				break;
			case 'SPECIALTY':
				$vpage="looprint/rptloo_spe";
				break;  
		}
        $data['resultd'] = $this->model_looprint->sholdetilby_id($loo_id);    
		//$this->load->view($vpage, $data);
		
        $html=$this->load->view($vpage, $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptloo.pdf";
        $this->m_pdf->pdf->SetFont('zaskiagothic');
		$this->m_pdf->pdf->setFooter('{PAGENO}/{nbpg}');
		$pieces = explode("/",$loo_id);
		$vnocount=$pieces[1];
		$vroma=$pieces[4];
		$vnolo=str_pad($vnocount,4, '0', STR_PAD_LEFT);
		$nolo="Ref.".$vnolo."/LOO/DIR/TCP/CT/".$vroma;
		$this->m_pdf->pdf->SetHTMLHeader('<table width="100%"><tr><td align="left" style="font-size:10px">'.$nolo.'</td></tr><tr><td align="left" style="font-size:10px">Page :{PAGENO}/{nb}</td></tr></table>');
		$this->m_pdf->pdf->AddPage('P','','','','',35,35,30,30,20,0);
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
		
        
        
    }   

    function invprintpdf(){     

        $i_link = $this->uri->segment(4);       
        $loo_id = str_replace('_', '/', $i_link); 


        $print_name = $this->session->userdata('user_fullname');

        $_dp  =$this->model_looprint->getdepe($loo_id);
        $v_dp =$_dp['dp'];        
        
        $data   = array(
                  'result'      => $this->model_looprint->viewinvprint($loo_id),
                  'print_name'  => $print_name                  
               );                

//$this->load->view('looprint/rptinpro', $data);
        $html=$this->load->view('looprint/rptinpro', $data, TRUE);
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
	
	function versi_print()
	{ 
				$i_link = $this->uri->segment(4);       
				$loo_id = str_replace('_', '/', $i_link); 
				 
				$vsc=$this->model_looprint->getservicecharge($loo_id);
				$vhargasc=$vsc['servicecharge'];
				if ($vhargasc>0){$vhargasc=$vhargasc;}else{$vhargasc=0;}

				$vpl=$this->model_looprint->getloodesc($loo_id);
				$vloodes=$vpl['loo_descr'];

				$dps=$this->model_looprint->getdepositr($loo_id);
				$vdps=$dps['depositr'];

				$rpromo=$this->model_looprint->getpromolevy($loo_id);
				//echo var_dump($rpromo);
				
				$vpromolevy=$rpromo['promolevy'];
				if ($vpromolevy>0){$vpromolevy=$vpromolevy;}else{$vpromolevy=0;}
				
				$pieces = explode("/",$loo_id); 
				$vnocount=$pieces[1];
				$vroma=$pieces[4];
				$vnolo=str_pad($vnocount,4, '0', STR_PAD_LEFT);
				$nolo="Ref.".$vnolo."/LOO/DIR/TCP/LT/".$vroma; 
				
				

			$data   = array(
					'result'    => $this->model_looprint->viewlooprint($loo_id),
					'ritem' => $this->model_looprint->getitemagreement($loo_id),
					'loo_id'   => $loo_id,
					'ref_loo'   => $nolo,
					'vunit'    => $this->model_looprint->getunitloo($loo_id),
					'vhargasewa'    => $this->model_looprint->gethargasewa($loo_id),
					'vhargasc' =>$vhargasc,
					'vloodes' =>$vloodes,
					'vdps' =>$vdps,
					'vpromolevy' =>$vpromolevy,
					'rgm' => $this->model_looprint->getwebsetting('2'),
					'rstaff' => $this->model_looprint->getwebsetting('3'),
					'resultdetil' => $this->model_looprint->viewlooprintdetil($loo_id),
					'ttd_loo' => $this->model_looprint->show_settingLOOReport(),

			);     
			
			// echo "<pre/>";
			// echo var_dump($data['resultdetil']);
			// exit;
		
		$pages = '';
		
		switch ($data['result'][0]->loo_tempid) {
			case 1: //fnb
				$pages = 'looprint/loo_cibubur';
				break;
			case 2: //speciality
				$pages = 'looprint/loo_cibubur_speciality';
				break;
			case 3: //optik
				$pages = 'looprint/loo_cibubur_optik';
				break;
			case 4: //profitsharing
				$pages = 'looprint/loo_cibubur_profitsharing';
				break;
			case 5: //casualleasing
				$pages = 'looprint/loo_cibubur_casual';
				break;
		}
		
		// echo $pages;
		// exit;
		
		// $this->load->view('looprint/loo_cibubur',$data);
		
        $html=$this->load->view($pages,$data,true);  
	
		$pdfFilePath = "$pages.pdf";

		$this->load->library('m_pdf'); 
		$this->m_pdf->pdf->AddPage('P','','','','',30,10,25,15,8,8);
		$this->m_pdf->pdf->WriteHTML($html);   		
		$this->m_pdf->pdf->Output($pdfFilePath, "I");  


		$this->m_pdf->pdf->shrink_tables_to_fit = 1;   
		$this->m_pdf->pdf->use_kwt = true;     
		$this->m_pdf->pdf->keep_table_proportions = false; 
		$this->m_pdf->pdf->SetDefaultFontSize(29);

		$this->m_pdf->pdf->WriteHTML($html);   		
		$this->m_pdf->pdf->Output($pdfFilePath, "I");  
		
	}
	 
	
}  