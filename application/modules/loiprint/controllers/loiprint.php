<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loiprint extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_loiprint');


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
	
      function loiprintpdf(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
                $vpl=$this->model_loiprint->getloiunit($loo_id);
                $vunitloi=$vpl['unit'];				
				$agid = substr($loo_id,0,2);	
				
				if($agid == 'AT')
				{
					$regionid=$this->model_loiprint->getregionidAT($loo_id);
					$uangsewa=$this->model_loiprint->getuangsewaAT($loo_id);
					$uang_sewa = $uangsewa['agreementdetil_baserent'];	
					$total_sewa = $uangsewa['agreementdetil_totalleaserent'];				
					$DP=$this->model_loiprint->getDPAT($loo_id);
					$FoodLevy=$this->model_loiprint->getfoodlevyAT($loo_id);
					$Service=$this->model_loiprint->getserviceAT($loo_id);
					$Deposit=$this->model_loiprint->getdepositAG($loo_id);
					$SumDeposit=$this->model_loiprint->getsumdepositAT($loo_id);
					$TelpDeposit=$this->model_loiprint->gettelpdepositAT($loo_id);
					$TelpService=$this->model_loiprint->gettelpserviceAT($loo_id);
					$Agreement=$this->model_loiprint->getagreementAT($loo_id);
					$Listrik=$this->model_loiprint->getlistrikAT($loo_id);
					$listrik = $Listrik['agreementdetil_mia'];					
					}
				elseif($agid == 'AG') 
				{
					$regionid=$this->model_loiprint->getregionid($loo_id);
					$uangsewa=$this->model_loiprint->getuangsewaAG($loo_id);
					$uang_sewa = $uangsewa['agreementdetil_baserent'];
					$total_sewa = $uangsewa['agreementdetil_totalleaserent'];
					$DP=$this->model_loiprint->getDPAG($loo_id);
					$FoodLevy=$this->model_loiprint->getfoodlevyAG($loo_id);
					$Service=$this->model_loiprint->getserviceAG($loo_id);	
					$Deposit=$this->model_loiprint->getdepositAG($loo_id);
					$SumDeposit=$this->model_loiprint->getsumdepositAG($loo_id);
					$TelpDeposit=$this->model_loiprint->gettelpdepositAG($loo_id);
					$TelpService=$this->model_loiprint->gettelpserviceAG($loo_id);	
					$Agreement=$this->model_loiprint->getagreementAG($loo_id);
					$Listrik=$this->model_loiprint->getlistrikAG($loo_id);
					$listrik = $Listrik['agreementdetil_mia'];					
					}
				$vregionid=$regionid['region_id'];	
									
				$DP_percent = $DP['agreementdetil_percent'];	
				$DP_value = $DP['agreementdetil_mia'];
				$jml_DP = $DP['agreementdetil_installmentpayment'];	
				$angsuran_DP = $DP_value / $jml_DP; 	
				$sisa_percent = 100 - $DP_percent;	
				$sisa_total_sewa = $total_sewa - $DP_value;	
				$biaya_food_levy = $FoodLevy['agreementdetil_mia'];
				$biaya_service = $Service['agreementdetil_baserent'];
				$jml_deposit = $Deposit['agreementdeposit_duedate'];
				$deposit_value =$SumDeposit['agreementdeposit_idr'];
				$telp_deposit =$TelpDeposit['agreementdeposit_idr'];
				$telp_service =$TelpService['agreementdeposit_idr'];
				$jangka=$Agreement['agreement_term'];

				if($biaya_food_levy == '')
				{
					$biaya_food_levy = 0;
					}
				if($biaya_service == '')
				{
					$biaya_service = 0;
					}					
				if($jml_deposit == '')
				{
					$jml_deposit = 0;
					}									
				if($telp_deposit == '')
				{
					$telp_deposit = 0;
					}
				if($telp_service == '')
				{
					$telp_service = 0;
					}
				if($listrik == '')
				{
					$listrik = 0;
					}					
					
				$listrik_total = $listrik * $jangka;
				//echo $telp_service;		
				//echo exit;
									
               // $vunit2 = $this->model_loiprint->getunitloi($loo_id);
				//$vunitloi = $vunit2['unit'];
 
        $data   = array(
                  'result'    => $this->model_loiprint->viewloiprint($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_loiprint->getunitloo($loo_id),				  
				  'Position1_name' => $this->model_loiprint->getmastersetting('Print_LOI_Position1_name'),
				  'Position1' => $this->model_loiprint->getmastersetting('Print_LOI_Position1'),
				  'Position2_name' => $this->model_loiprint->getmastersetting('Print_LOI_Position2_name'),
				  'Position2' => $this->model_loiprint->getmastersetting('Print_LOI_Position2'),                  
                  'vregion'    => $this->model_loiprint->getmasterregion($vregionid),
				  'uang_sewa' =>$uang_sewa,
				  'total_sewa' =>$total_sewa,
				  'DP_percent' =>$DP_percent,
				  'DP_value' =>$DP_value,
				  'jml_DP' =>$jml_DP,
				  'angsuran_DP' =>$angsuran_DP,
				  'sisa_percent'	=>$sisa_percent,
				  'sisa_total_sewa'	=>$sisa_total_sewa,
				  'biaya_food_levy'	=>$biaya_food_levy,
				  'biaya_service'	=>$biaya_service,
				  'jml_deposit'	=>$jml_deposit,
				  'deposit_value'	=>$deposit_value,
				  'telp_deposit'	=>$telp_deposit,
				  'telp_service'	=>$telp_service,
				  'jangka'	=>$jangka,
				  'listrik'	=>$listrik,
				  'listrik_total' =>$listrik_total				  				  				  			  
				  								  				  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_loiprint->sholdetilby_id($loo_id);    

		$unit = substr($vunitloi,0,3);
		
		//echo $unit;
		//echo exit;
		
		if($agid == 'AT')
		{
			if ($unit == 'ATM')
			{
				$html=$this->load->view('loiprint/rptloi_atm', $data,TRUE);
				$this->load->library('m_pdf');
				$pdfFilePath = "rptloi_atm.pdf";				
			}
			else
			{
				$html=$this->load->view('loiprint/rptloi_cl', $data,TRUE);
				$this->load->library('m_pdf');
				$pdfFilePath = "rptloi_cl.pdf";				
			}
					
		}
		elseif($agid == 'AG') 
		{
			if ($unit == 'ATM')
			{
				$html=$this->load->view('loiprint/rptloi_atm', $data,TRUE);
				$this->load->library('m_pdf');
				$pdfFilePath = "rptloi_atm.pdf";				
			}
			else
			{
				$html=$this->load->view('loiprint/rptloi', $data,TRUE);
				$this->load->library('m_pdf');
				$pdfFilePath = "rptloi.pdf";				
			}			
		}


        //$this->m_pdf->pdf->SetFont('zaskiagothic');
		//$this->m_pdf->pdf->setFooter('{PAGENO}/{nbpg}');
		$this->m_pdf->pdf->SetHTMLHeader('<table width="100%"><tr><td align="right" style="font-size:10px"></td></tr></table>');
		$this->m_pdf->pdf->AddPage('P','','','','',35,35,25,30,15,8);
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        
        
    }   
	
	function printatmpdf(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_loiprint->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_loiprint->getloodesc($loo_id);
                $vloodes=$vpl['loo_descr'];
                
                $dps=$this->model_loiprint->getdepositr($loo_id);
                $vdps=$dps['depositr'];
 
        $data   = array(
                  'result'    => $this->model_loiprint->viewatmprint($loo_id),
				  'ritem' => $this->model_loiprint->getitemagreementatm($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_loiprint->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_loiprint->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vloodes' =>$vloodes,
                  'vdps' =>$vdps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_loiprint->sholdetilby_id($loo_id);    

        $html=$this->load->view('loiprint/rptof_atm1', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptloi.pdf";
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        
        
    }  
	
	function printatm2pdf(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_loiprint->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_loiprint->getloodesc($loo_id);
                $vloodes=$vpl['loo_descr'];
                
                $dps=$this->model_loiprint->getdepositr($loo_id);
                $vdps=$dps['depositr'];
 
        $data   = array(
                  'result'    => $this->model_loiprint->viewatmprint($loo_id),
				  'ritem' => $this->model_loiprint->getitemagreementatm($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_loiprint->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_loiprint->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vloodes' =>$vloodes,
                  'vdps' =>$vdps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_loiprint->sholdetilby_id($loo_id);    

        $html=$this->load->view('loiprint/rptof_atm2', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptloi.pdf";
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        
        
    }    
	
	function printatmpdfloo(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_loiprint->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_loiprint->getloodesc($loo_id);
                $vloodes=$vpl['loo_descr'];
                
                $dps=$this->model_loiprint->getdepositr($loo_id);
                $vdps=$dps['depositr'];
 
        $data   = array(
                  'result'    => $this->model_loiprint->viewatmprint($loo_id),
				  'ritem' => $this->model_loiprint->getitemagreementatm($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_loiprint->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_loiprint->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vloodes' =>$vloodes,
                  'vdps' =>$vdps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_loiprint->sholdetilby_id($loo_id);    

        $html=$this->load->view('loiprint/rptof_atm1loo', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptloi.pdf";
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        
        
    }  
	
	function printatm2pdfloo(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_loiprint->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_loiprint->getloodesc($loo_id);
                $vloodes=$vpl['loo_descr'];
                
                $dps=$this->model_loiprint->getdepositr($loo_id);
                $vdps=$dps['depositr'];
 
        $data   = array(
                  'result'    => $this->model_loiprint->viewatmprint($loo_id),
				  'ritem' => $this->model_loiprint->getitemagreementatm($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_loiprint->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_loiprint->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vloodes' =>$vloodes,
                  'vdps' =>$vdps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_loiprint->sholdetilby_id($loo_id);    

        $html=$this->load->view('loiprint/rptof_atm2loo', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptloi.pdf";
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        
        
    }
	
	function printbts(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_loiprint->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_loiprint->getloodesc($loo_id);
                $vloodes=$vpl['loo_descr'];
                
                $dps=$this->model_loiprint->getdepositr($loo_id);
                $vdps=$dps['depositr'];
				
				
 
        $data   = array(
                  'result'    => $this->model_loiprint->viewbtsprint($loo_id),
				  'ritem' => $this->model_loiprint->getitemagreementatm($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_loiprint->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_loiprint->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vloodes' =>$vloodes,
                  'vdps' =>$vdps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_loiprint->sholdetilby_id($loo_id);    
//$this->load->view('loiprint/rptbts', $data);
       $html=$this->load->view('loiprint/rptbts', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptloi.pdf";
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I"); 
       
    }    
	
	
}  