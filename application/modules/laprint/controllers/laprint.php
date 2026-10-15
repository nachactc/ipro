<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laprint extends MX_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_laprint');

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
	
    function la_printpdf(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
        $view_detil = '';        
             
 
        $data   = array(
                  'result'    => $this->model_laprint->viewlooprint($loo_id) 
               );                 
		if(count($data['result']) <= 0)
		{
			echo "Data Unit Transaksi atau Data Unit di MASTER UNIT tidak sama / tidak ada datanya";
			echo "<br/>";
			echo "Atau Agreement Belum Di buat atau di Posting";
			echo "<br/>";
			echo "Harap Cek Data Transaksi Agreement ( UNIT NYA ) di cek kembali!";
			echo "<br/>";
			echo "Pastikan Data Unit Di transaksi ada di master unit";
			exit;
		}
		$result['branch'] = $data['result']->branch_name;	
		$result['loo_id'] = nola_header($data['result']->loo_id);	
		$result['rekananshipping_name'] = $data['result']->rekananshipping_name;
		$result['telp'] = $data['result']->rekananshipping_contacttelp;
		$result['rekananshippingtype_name'] = $data['result']->rekananshippingtype_name;
		$result['rekananshipping_type'] = $data['result']->rekananshipping_type;
		
		// if ($data['result']->grouptenant_id == 'pt')
		// { 
			//untuk PT
			// if($data['result']->rekananshipping_type == 'unit') //unit
			// {
				// $view_detil = 'laprint/rptla_unit';	
				// echo "1";
			// } 
			// if($data['result']->rekananshipping_type == 'island') //island
			// {
				// $view_detil = 'laprint/rptla_island';	
			// } 
			// if($data['result']->rekananshipping_type == 'foodcourt') //foodcourt
			// {
				// $view_detil = 'laprint/rptla_foodcourt';		
			// }
			// else //pushcart
			// {
				// $view_detil = 'laprint/rptla';	
			// }
		// }
		// elseif($data['result']->grouptenant_id == 'personal')
		// {
			 
			if($data['result']->rekananshipping_type == 'unit') //unit
			{
				$view_detil = 'laprint/rptla_unit_p'; 
			}
			elseif($data['result']->rekananshipping_type == 'island') //island
			{ 
				$view_detil = 'laprint/rptla_island_p';	
				 
			}
			elseif($data['result']->rekananshipping_type == 'foodcourt') //foodcourt
			{
				$view_detil = 'laprint/rptla_foodcourt_p';	
			}
			else
			{
				$view_detil = 'laprint/rptla';	//pushcart
			}
		// } 
		
		//$this->load->view('laprint/rptla', $result);
		  
		 $html=$this->load->view($view_detil, $result,TRUE);
		 
         $this->load->library('m_pdf');
         $pdfFilePath = "rptloo.pdf";
       
         $this->m_pdf->pdf->WriteHTML($html);
         $this->m_pdf->pdf->Output($pdfFilePath, "I");   
    }   
	
	function la_ap_iv_printpdf(){     
		$i_link = $this->uri->segment(4);       
		$loo_id = str_replace('_', '/', $i_link); 
        $view_detil = '';     
        $data   = array(
                  'result'    => $this->model_laprint->viewlooprint($loo_id) 
               );                
        // echo var_dump($this->model_laprint->viewlooprint('SMM/297/LOO/TRI/XII-17'));
		// exit;
		if(count($data['result']) <= 0)
		{
			echo "Data Unit Transaksi atau Data Unit di MASTER UNIT tidak sama / tidak ada datanya";
			echo "<br/>";
			echo "Atau Agreement Belum Di buat atau di Posting";
			echo "<br/>";
			echo "Harap Cek Data Transaksi Agreement ( UNIT NYA ) di cek kembali!";
			echo "<br/>";
			echo "Pastikan Data Unit Di transaksi ada di master unit";
			exit;
		}
		$la_id_ = nola_header($loo_id);	
		$result['branch'] = $data['result']->branch_name;	
		$result['loo_id'] = $la_id_ == '' ? $loo_id : $la_id_; 
		$result['rekananshipping_name'] = $data['result']->rekananshipping_name;
		$result['telp'] = $data['result']->rekananshipping_contacttelp;
		$result['rekananshippingtype_name'] = $data['result']->rekananshippingtype_name;
		$result['rekananshipping_type'] = $data['result']->rekananshipping_type;
		//$view_detil = 'laprint/rptla_appendix_iv_personal';	
		
		if ($data['result']->grouptenant_id == 'personal')
		{ 
			$view_detil = 'laprint/rptla_appendix_iv_personal';	
		}
		else
		{
			$view_detil = 'laprint/rptla_appendix_iv';	
		}
		 
		//$this->load->view('laprint/rptla', $result);
		  
		 $html=$this->load->view($view_detil, $result,TRUE);
		 
         $this->load->library('m_pdf');
         $pdfFilePath = "rptloo.pdf";
       
         $this->m_pdf->pdf->WriteHTML($html);
         $this->m_pdf->pdf->Output($pdfFilePath, "I");   
    }   
	
	function printatmpdf(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_laprint->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_laprint->getloodesc($loo_id);
                $vloodes=$vpl['loo_descr'];
                
                $dps=$this->model_laprint->getdepositr($loo_id);
                $vdps=$dps['depositr'];
 
        $data   = array(
                  'result'    => $this->model_laprint->viewatmprint($loo_id),
				  'ritem' => $this->model_laprint->getitemagreementatm($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_laprint->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_laprint->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vloodes' =>$vloodes,
                  'vdps' =>$vdps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_laprint->sholdetilby_id($loo_id);    

        $html=$this->load->view('looprint/rptof_atm1', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptloo.pdf";
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        
        
    }  
	
	function printatm2pdf(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_laprint->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_laprint->getloodesc($loo_id);
                $vloodes=$vpl['loo_descr'];
                
                $dps=$this->model_laprint->getdepositr($loo_id);
                $vdps=$dps['depositr'];
 
        $data   = array(
                  'result'    => $this->model_laprint->viewatmprint($loo_id),
				  'ritem' => $this->model_laprint->getitemagreementatm($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_laprint->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_laprint->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vloodes' =>$vloodes,
                  'vdps' =>$vdps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_laprint->sholdetilby_id($loo_id);    

        $html=$this->load->view('looprint/rptof_atm2', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptloo.pdf";
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        
        
    }    
	
	function printatmpdfloo(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_laprint->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_laprint->getloodesc($loo_id);
                $vloodes=$vpl['loo_descr'];
                
                $dps=$this->model_laprint->getdepositr($loo_id);
                $vdps=$dps['depositr'];
 
        $data   = array(
                  'result'    => $this->model_laprint->viewatmprint($loo_id),
				  'ritem' => $this->model_laprint->getitemagreementatm($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_laprint->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_laprint->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vloodes' =>$vloodes,
                  'vdps' =>$vdps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_laprint->sholdetilby_id($loo_id);    

        $html=$this->load->view('looprint/rptof_atm1loo', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptloo.pdf";
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        
        
    }  
	
	function printatm2pdfloo(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_laprint->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_laprint->getloodesc($loo_id);
                $vloodes=$vpl['loo_descr'];
                
                $dps=$this->model_laprint->getdepositr($loo_id);
                $vdps=$dps['depositr'];
 
        $data   = array(
                  'result'    => $this->model_laprint->viewatmprint($loo_id),
				  'ritem' => $this->model_laprint->getitemagreementatm($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_laprint->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_laprint->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vloodes' =>$vloodes,
                  'vdps' =>$vdps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_laprint->sholdetilby_id($loo_id);    

        $html=$this->load->view('looprint/rptof_atm2loo', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptloo.pdf";
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        
        
    }
	
	function printbts(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_laprint->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_laprint->getloodesc($loo_id);
                $vloodes=$vpl['loo_descr'];
                
                $dps=$this->model_laprint->getdepositr($loo_id);
                $vdps=$dps['depositr'];
				
				
 
        $data   = array(
                  'result'    => $this->model_laprint->viewbtsprint($loo_id),
				  'ritem' => $this->model_laprint->getitemagreementatm($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_laprint->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_laprint->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vloodes' =>$vloodes,
                  'vdps' =>$vdps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_laprint->sholdetilby_id($loo_id);    
//$this->load->view('looprint/rptbts', $data);
       $html=$this->load->view('looprint/rptbts', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptloo.pdf";
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I"); 
       
    }    
	
	
}  