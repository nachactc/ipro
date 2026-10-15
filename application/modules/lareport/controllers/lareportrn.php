<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lareportrn extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        $this->load->model('model_lareport');
		 $this->load->model('looprint/model_looprint');
		$this->load->library('breadcrumbcomponent');

    }
	function lakhusus(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link);   
				$pieces = explode("/",$loo_id); 
				$pieces2 = explode("-",$loo_id); 
				$rshortbranch=$this->model_lareport->qry_getbranchshort($loo_id);
				$branchsht=$rshortbranch['branch_nameshort'];
				$rshipname=$this->model_lareport->qry_getshipname($loo_id);
				$vshipname=$rshipname['rekananshipping_name'];
				
				$aromawi=substr($pieces[4],0,2);
				$atahun="20".$pieces2[1];
				
				$nola=$vshipname." - "." Nomor : ".$pieces[1]."/LA-".$branchsht."/A&D/".$pieces[3]."/".$aromawi."/".$atahun;
				$nolah=$pieces[1]."/LA-".$branchsht."/A&D/".$pieces[3]."/".$aromawi."/".$atahun;
				
				$data   = array(
				  'nola'    => $nola,
				  'nolah'    => $nolah,
				   'rloo'    => $this->model_lareport->get_loibyid($loo_id),
                  
               );    
			   

        $html=$this->load->view('lareport/rptlapersonal_khusus', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptlakhusus.pdf";
		$this->m_pdf->pdf->AddPage('P','','','','',30,10,25,15,8,8);
		$this->m_pdf->pdf->WriteHTML($html);
		ob_clean();
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        exit();
    }   
	
	function la_save()
	{
		
		$loo_id=$this->input->post('vloo_id'); 
		$xloo_id=$this->input->post('loo_id'); 
			   
		$txtpemegang1="";
		$txtpemegang2="";
		$txtdewankomisaris="";
		$txtkomut="";
		$txtkomisaris="";
		$txtaggotadir="";
		$txtdirut="";
		$txtdirektur=$this->input->post('txtdirektur');
		$txtfitout=$this->input->post('txtfitout');
		
		$txttggjawab=$this->input->post('txttggjawab');
		$txtjabatanjawab=$this->input->post('txtjabatanjawab');
		$txtjabatansewa=$this->input->post('txtjabatansewa');
		$txtdatettd=$this->input->post('txtdatettd');
		
		$tuangsewa=$this->input->post('tuangsewa');
		$tbiayaservice=$this->input->post('tbiayaservice');
		
		$txtjenisusaha=$this->input->post('txtjenisusaha');
		$txtmerkdagang=$this->input->post('txtmerkdagang');
		$txtgrace=0;
		$txtpenyewa=$this->input->post('txtpenyewa');
		
		$this->model_lareport->mdl_lasave($loo_id,$txtpemegang1,$txtpemegang2,$txtdewankomisaris,$txtkomut,$txtkomisaris,$txtaggotadir,$txtdirut,$txtdirektur,$txtfitout,$xloo_id,$txttggjawab,$txtjabatanjawab,$txtjabatansewa,$txtdatettd,$tuangsewa,$tbiayaservice,$txtjenisusaha,$txtmerkdagang,$txtgrace,$txtpenyewa);
		
		 redirect('lareport/lalist');
		
		
	}
	
function lainput_detil()
	{		
       $i_link = $this->uri->segment(3);    
       $loo_id = str_replace('_', '/', $i_link);   
 	   $data   = array(
                'result'    => $this->model_lareport->get_laedit($loo_id),
				'rlooid'    => $loo_id
        );    
  		$this->breadcrumbcomponent->add('LA Status','lareport/lalist')
            ->add('Input Detail LA','lareport/lainput_detil');


        $this->load->view('template/v_header');
        $this->load->view('lareport/la_add', $data);
        $this->load->view('template/v_footer');
	}
	
	function lainput_detilloc()
	{		
       $i_link = $this->uri->segment(4);    
       $loo_id = str_replace('_', '/', $i_link);   
 	   $data   = array(
                'result'    => $this->model_lareport->get_laedit($loo_id),
				'rlooid'    => $loo_id
        );    
  		$this->breadcrumbcomponent->add('LA Status','lareport/lalist')
            ->add('Input Detail LA','lareport/lainput_detil');


        $this->load->view('template/v_header');
        $this->load->view('lareport/la_addloc', $data);
        $this->load->view('template/v_footer');
	}
	
	function rptbtsprint(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link);   
				$pieces = explode("/",$loo_id); 
				$pieces2 = explode("-",$loo_id); 
				$rshortbranch=$this->model_lareport->qry_getbranchshort($loo_id);
				$branchsht=$rshortbranch['branch_nameshort'];
				$rshipname=$this->model_lareport->qry_getshipname($loo_id);
				$vshipname=$rshipname['rekananshipping_name'];
				
				$aromawi=substr($pieces[4],0,2);
				$atahun="20".$pieces2[1];
				
				$nola=$vshipname." - "." Nomor : ".$pieces[1]."/LA-".$branchsht."/A&D/".$pieces[3]."/".$aromawi."/".$atahun;
				$nolah=$pieces[1]."/LA-".$branchsht."/A&D/".$pieces[3]."/".$aromawi."/".$atahun;
				$rsewa=$this->model_lareport->qry_getsewa($loo_id);
				$nilsewa=$rsewa['agreementdetil_baserent'];
				$nilsewatotal=$rsewa['agreementdetil_totalleaseunitrate'];
				$rpercentdp=$this->model_lareport->qry_getpercendp($loo_id);
				$vpercentdp=$rpercentdp['agreementdetil_percent'];
				
				$rrpdp=$this->model_lareport->qry_getrupdp($loo_id);
				$vrpdp=$rrpdp['agreementdetil_mia'];
				
				
				$rinstaldp=$this->model_lareport->qry_getintdp($loo_id);
				$vinstaldp=$rinstaldp['instaldp'];
				
				$rconname=$this->model_lareport->qry_contactname($loo_id);
				$vconname=$rconname['rekanancontact_name'];
				
				$rlantai=$this->model_lareport->qry_getflbyid($loo_id);
				$vlantai=$rlantai['lantai_name'];
				
				
				$jumrentloi=$this->model_lareport->get_countrentloi($loo_id);
				$rtotdeposit=$this->model_lareport->get_totaldeposit($loo_id);
				
				if ($rtotdeposit['niltotal']>0){
				$rtotdeposit=$rtotdeposit['niltotal'];
				}else{
				$rtotdeposit=0;
				}
				
				$rtotrent=$this->model_lareport->get_totalrent($loo_id);
				$rtotrent=$rtotrent['totalrent'];
				$rcekarea=$this->model_lareport->get_cekarea($loo_id);
				$rkomisaris=$this->model_lareport->qry_strukturkomisaris($loo_id);
				
				$roin=$this->model_lareport->get_totalrentindoor($loo_id);
				$roin=$roin['totalrent'];
				$rout=$this->model_lareport->get_totalrentoutdoor($loo_id);
				$rout=$rout['totalrent'];

        $data   = array(
                  'result'    => $this->model_lareport->viewloo($loo_id),
				  'rloo'    => $this->model_lareport->get_loibyid($loo_id),
				  'rloi'    => $this->model_lareport->get_detilloirent($loo_id),
				  'rloirent'    => $this->model_lareport->get_detilloirentsingle($loo_id),
				  'rintservice' => $this->model_lareport->get_intvpelayanan($loo_id),	
				  'rnilaiservice' => $this->model_lareport->get_nilaipelayanan($loo_id),
				  'rnilaipromo' => $this->model_lareport->get_nilaipromosi($loo_id),	
				  'rgplv' => $this->model_lareport->get_nilaigplv($loo_id),	
				  'rkomisaris' => $rkomisaris,
				  'roin' => $roin,
				  'rout' => $rout,
				  'rtotdeposit' => $rtotdeposit,	
				  'rtotrent' => $rtotrent,	
				  'rcekarea' => $rcekarea,	  			  
				  'nilsewa'    =>$nilsewa,
				  'jumrentloi'    =>$jumrentloi['jumlah'],
				  'nilsewatotal'=>$nilsewatotal,
				  'nola'    => $nola,
				  'nolah'    => $nolah,
				  'vlantai' => $vlantai,
				  'vpercentdp' => $vpercentdp,
				  'vrpdp' => $vrpdp,
				  'vinstaldp' => $vinstaldp,
				  'vconname' => $vconname,
				  'vunit'    => $this->model_looprint->getunitloo($loo_id)
                  
               );    

        $html=$this->load->view('lareport/rptbts', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptbts.pdf";
        //$this->m_pdf->pdf->SetFont('zaskiagothic');
		//$this->m_pdf->pdf->setFooter('{PAGENO}/{nbpg}');
		
		//$this->m_pdf->pdf->list_marker_offset = '5.5pt';
		//$this->m_pdf->pdf->list_symbol_size = '3.6pt';
		//$this->m_pdf->pdf->SetHTMLFooter($footer);
		//$this->m_pdf->pdf->AddPage('','A4','','',3,3,2,2,2,2,'P');
		//$this->m_pdf->pdf->SetHTMLHeader('<div style="text-align: left; ">No : '.$nolah.'</div><div style="text-align: right;">{PAGENO}</div>');
		if (strlen($rkomisaris['tgl_sign'])>0){
				$tgt=$rkomisaris['tgl_sign'];
		}else{
			$tgt=date('Y-m-d');
		}
		$tgttd = date('d F Y', strtotime($tgt));
		$this->m_pdf->pdf->SetHTMLHeader('<table width="100%"><tr><td align="right" style="font-size:10px">SHOPPING MALL – LEASE  AGREEMENT '.$vshipname.'</td></tr><tr><td><hr></td></tr></table>', 'O', true);
		
		$this->m_pdf->pdf->SetHTMLFooter('<table width="100%"><tr><td align="left" style="font-size:10px;">'.$vshipname.'-No.'.$nolah.'</td><td align="right" style="font-size:10px">{PAGENO}/{nb}</td></tr></table>');
		$this->m_pdf->pdf->AddPage('P','','','','',30,30,30,20,20,10);
		$this->m_pdf->pdf->SetHTMLHeader('');
		$this->m_pdf->pdf->WriteHTML($html);
		ob_clean();
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        exit();
    } 
	
	function lapersonalprint(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link);   
				$pieces = explode("/",$loo_id); 
				$pieces2 = explode("-",$loo_id); 
				$rshortbranch=$this->model_lareport->qry_getbranchshort($loo_id);
				$branchsht=$rshortbranch['branch_nameshort'];
				$rshipname=$this->model_lareport->qry_getshipname($loo_id);
				$vshipname=$rshipname['rekananshipping_name'];
				
				$aromawi=substr($pieces[4],0,2);
				$atahun="20".$pieces2[1];
				
				$nola=$vshipname." - "." Nomor : ".$pieces[1]."/LA-".$branchsht."/A&D/".$pieces[3]."/".$aromawi."/".$atahun;
				$nolah=$pieces[1]."/LA-".$branchsht."/A&D/".$pieces[3]."/".$aromawi."/".$atahun;
				$rsewa=$this->model_lareport->qry_getsewa($loo_id);
				$nilsewa=$rsewa['agreementdetil_baserent'];
				$nilsewatotal=$rsewa['agreementdetil_totalleaseunitrate'];
				$rpercentdp=$this->model_lareport->qry_getpercendp($loo_id);
				$vpercentdp=$rpercentdp['agreementdetil_percent'];
				
				$rrpdp=$this->model_lareport->qry_getrupdp($loo_id);
				$vrpdp=$rrpdp['agreementdetil_mia'];
				
				
				$rinstaldp=$this->model_lareport->qry_getintdp($loo_id);
				$vinstaldp=$rinstaldp['instaldp'];
				
				$rconname=$this->model_lareport->qry_contactname($loo_id);
				$vconname=$rconname['rekanancontact_name'];
				
				$rlantai=$this->model_lareport->qry_getflbyid($loo_id);
				$vlantai=$rlantai['lantai_name'];
				
				
				$jumrentloi=$this->model_lareport->get_countrentloi($loo_id);
				$rtotdeposit=$this->model_lareport->get_totaldeposit($loo_id);
				
				if ($rtotdeposit['niltotal']>0){
				$rtotdeposit=$rtotdeposit['niltotal'];
				}else{
				$rtotdeposit=0;
				}
				
				$rtotrent=$this->model_lareport->get_totalrent($loo_id);
				$rtotrent=$rtotrent['totalrent'];
				$rcekarea=$this->model_lareport->get_cekarea($loo_id);
				$rkomisaris=$this->model_lareport->qry_strukturkomisaris($loo_id);
				
				$roin=$this->model_lareport->get_totalrentindoor($loo_id);
				$roin=$roin['totalrent'];
				$rout=$this->model_lareport->get_totalrentoutdoor($loo_id);
				$rout=$rout['totalrent'];

        $data   = array(
                  'result'    => $this->model_lareport->viewloo($loo_id),
				  'rloo'    => $this->model_lareport->get_loibyid($loo_id),
				  'rloi'    => $this->model_lareport->get_detilloirent($loo_id),
				  'rloirent'    => $this->model_lareport->get_detilloirentsingle($loo_id),
				  'rintservice' => $this->model_lareport->get_intvpelayanan($loo_id),	
				  'rnilaiservice' => $this->model_lareport->get_nilaipelayanan($loo_id),
				  'rnilaipromo' => $this->model_lareport->get_nilaipromosi($loo_id),	
				  'rgplv' => $this->model_lareport->get_nilaigplv($loo_id),	
				  'rkomisaris' => $rkomisaris,
				  'roin' => $roin,
				  'rout' => $rout,
				  'rtotdeposit' => $rtotdeposit,	
				  'rtotrent' => $rtotrent,	
				  'rcekarea' => $rcekarea,	  			  
				  'nilsewa'    =>$nilsewa,
				  'jumrentloi'    =>$jumrentloi['jumlah'],
				  'nilsewatotal'=>$nilsewatotal,
				  'nola'    => $nola,
				  'nolah'    => $nolah,
				  'vlantai' => $vlantai,
				  'vpercentdp' => $vpercentdp,
				  'vrpdp' => $vrpdp,
				  'vinstaldp' => $vinstaldp,
				  'vconname' => $vconname,
				  'vunit'    => $this->model_looprint->getunitloo($loo_id)
                  
               );    
			   


        $html=$this->load->view('lareport/rptlapersonal', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptlapersonal.pdf";
        //$this->m_pdf->pdf->SetFont('zaskiagothic');
		//$this->m_pdf->pdf->setFooter('{PAGENO}/{nbpg}');
		
		//$this->m_pdf->pdf->list_marker_offset = '5.5pt';
		//$this->m_pdf->pdf->list_symbol_size = '3.6pt';
		//$this->m_pdf->pdf->SetHTMLFooter($footer);
		//$this->m_pdf->pdf->AddPage('','A4','','',3,3,2,2,2,2,'P');
		//$this->m_pdf->pdf->SetHTMLHeader('<div style="text-align: left; ">No : '.$nolah.'</div><div style="text-align: right;">{PAGENO}</div>');
		if (strlen($rkomisaris['tgl_sign'])>0){
				$tgt=$rkomisaris['tgl_sign'];
		}else{
			$tgt=date('Y-m-d');
		}
		$tgttd = date('d F Y', strtotime($tgt));
		$this->m_pdf->pdf->SetHTMLHeader('<table width="100%"><tr><td align="left" style="font-size:10px">No : '.$nolah.'</td><td align="right" style="font-size:10px">'.$tgttd.'</td></tr></table>', 'O', true);
		
		$this->m_pdf->pdf->SetHTMLFooter('<table width="100%"><tr><td align="left" style="font-size:10px">'.$vshipname.'-No.'.$nolah.'</td><td align="right" style="font-size:10px">{PAGENO}/{nb}</td></tr></table>');
		$this->m_pdf->pdf->AddPage('P','','','','',30,30,30,20,20,10);
		$this->m_pdf->pdf->SetHTMLHeader('');
		$this->m_pdf->pdf->WriteHTML($html);
		ob_clean();
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        exit();
    }   
 
 
 function lapersonalprintrn(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link);   
				$pieces = explode("/",$loo_id); 
				$pieces2 = explode("-",$loo_id); 
				$rshortbranch=$this->model_lareport->qry_getbranchshortrn($loo_id);
				$branchsht=$rshortbranch['branch_nameshort'];
				$rshipname=$this->model_lareport->qry_getshipnamern($loo_id);
				$vshipname=$rshipname['rekananshipping_name'];
				
				$aromawi=substr($pieces[4],0,2);
				$atahun="20".$pieces2[1];
				
				$nola=$vshipname." - "." Nomor : ".$pieces[1]."/LA-".$branchsht."/A&D/".$pieces[3]."/".$aromawi."/".$atahun;
				$nolah=$pieces[1]."/ADD1-".$branchsht."/A&D/".$pieces[3]."/".$aromawi."/".$atahun;
				$rsewa=$this->model_lareport->qry_getsewa($loo_id);
				$nilsewa=$rsewa['agreementdetil_baserent'];
				$nilsewatotal=$rsewa['agreementdetil_totalleaseunitrate'];
				$rpercentdp=$this->model_lareport->qry_getpercendp($loo_id);
				$vpercentdp=$rpercentdp['agreementdetil_percent'];
				
				$rrpdp=$this->model_lareport->qry_getrupdp($loo_id);
				$vrpdp=$rrpdp['agreementdetil_mia'];
				
				
				$rinstaldp=$this->model_lareport->qry_getintdp($loo_id);
				$vinstaldp=$rinstaldp['instaldp'];
				
				$rconname=$this->model_lareport->qry_contactname($loo_id);
				$vconname=$rconname['rekanancontact_name'];
				
				$rlantai=$this->model_lareport->qry_getflbyidrn($loo_id);
				$vlantai=$rlantai['lantai_name'];
				
				
				$jumrentloi=$this->model_lareport->get_countrentloi($loo_id);
				$rtotdeposit=$this->model_lareport->get_totaldeposit($loo_id);
				
				if ($rtotdeposit['niltotal']>0){
				$rtotdeposit=$rtotdeposit['niltotal'];
				}else{
				$rtotdeposit=0;
				}
				
				$rtotrent=$this->model_lareport->get_totalrent($loo_id);
				$rtotrent=$rtotrent['totalrent'];
				$rcekarea=$this->model_lareport->get_cekarea($loo_id);
				$rkomisaris=$this->model_lareport->qry_strukturkomisaris($loo_id);
				
				$roin=$this->model_lareport->get_totalrentindoor($loo_id);
				$roin=$roin['totalrent'];
				$rout=$this->model_lareport->get_totalrentoutdoor($loo_id);
				$rout=$rout['totalrent'];
				
				$rsewarn=$this->model_lareport->gethargasewarn($loo_id);
				$rsewacurrent=$rsewarn['agreementdetil_mia'];
				
				$rlorn=$this->model_lareport->getlooidrn($loo_id);
				$looidrn=$rlorn['ref_id'];
				
				$rsewalast=$this->model_lareport->gethargasewarndulu($looidrn);
				$rsewalastnilai=$rsewalast['agreementdetil_mia'];
				$rtemplast=$rsewalast['agreement_term'];
				$rdaylast=$rsewalast['agreement_dayterm'];
				$rtmpstdate=$rsewalast['agreement_startdate'];
				$rtmpedate=$rsewalast['agreement_enddate'];
				
				$rlistrik=$this->model_lareport->getlistrikrn($loo_id);
				$rlistrikcurrent=$rlistrik['agreementdetil_baserent'];
				
				$rlistrikdulu=$this->model_lareport->getlistrikrndulu($looidrn);
				$rlistriklast=$rlistrikdulu['agreementdetil_baserent'];				

				$rsc=$this->model_lareport->getscrn($loo_id);
				$rsccurrent=$rsc['agreementdetil_baserent'];
				
				$rscdulu=$this->model_lareport->getscrndulu($looidrn);
				$rsclast=$rscdulu['agreementdetil_baserent'];
				
				
				$rtotdepositdulu=$this->model_lareport->get_totaldeposit($looidrn);
				
				if ($rtotdepositdulu['niltotal']>0){
				$rtotdepositdulu=$rtotdepositdulu['niltotal'];
				}else{
				$rtotdepositdulu=0;
				}

				$rtotdeposittelp=$this->model_lareport->get_totaldeposittelp($loo_id);
				if ($rtotdeposittelp['niltotal']>0){
				$rtotdeposittelp=$rtotdeposittelp['niltotal'];
				}else{
				$rtotdeposittelp=0;
				}
				
				$rtotdeposittelpdulu=$this->model_lareport->get_totaldeposittelp($looidrn);
				if ($rtotdeposittelpdulu['niltotal']>0){
				$rtotdeposittelpdulu=$rtotdeposittelpdulu['niltotal'];
				}else{
				$rtotdeposittelpdulu=0;
				}

				$rfood=$this->model_lareport->getfoodrn($loo_id);
				$rfoodcurrent=$rfood['agreementdetil_baserent'];
				
				$rfooddulu=$this->model_lareport->getfoodrn($loo_id);
				$rfooddulu=$rfooddulu['agreementdetil_baserent'];


        $data   = array(
                  'result'    => $this->model_lareport->viewloorn($loo_id),
				  'rloo'    => $this->model_lareport->get_loibyid($loo_id),
				  'rloi'    => $this->model_lareport->get_detilloirent($loo_id),
				  'rloirent'    => $this->model_lareport->get_detilloirentsingle($loo_id),
				  'rintservice' => $this->model_lareport->get_intvpelayanan($loo_id),	
				  'rnilaiservice' => $this->model_lareport->get_nilaipelayanan($loo_id),
				  'rnilaipromo' => $this->model_lareport->get_nilaipromosi($loo_id),	
				  'rgplv' => $this->model_lareport->get_nilaigplv($loo_id),	
				  'rkomisaris' => $rkomisaris,
				  'roin' => $roin,
				  'rout' => $rout,
				  'rtotdeposit' => $rtotdeposit,	
				  'rtotrent' => $rtotrent,	
				  'rcekarea' => $rcekarea,	  			  
				  'nilsewa'    =>$nilsewa,
				  'jumrentloi'    =>$jumrentloi['jumlah'],
				  'nilsewatotal'=>$nilsewatotal,
				  'nola'    => $nola,
				  'nolah'    => $nolah,
				  'vlantai' => $vlantai,
				  'vpercentdp' => $vpercentdp,
				  'vrpdp' => $vrpdp,
				  'vinstaldp' => $vinstaldp,
				  'vconname' => $vconname,
				  'rsewacurrent' => $rsewacurrent,
				  'rsewalastnilai' => $rsewalastnilai,		
				  'rtemplast' => $rtemplast,	
				  'rdaylast'=>$rdaylast,			  		  
				  'vunit'    => $this->model_looprint->getunitloorn($loo_id),
				  'loo_id' =>$loo_id,
				  'rlistrikcurrent' =>$rlistrikcurrent,
				  'rlistriklast' =>$rlistriklast,
				  'rsccurrent' =>$rsccurrent,
				  'rsclast' =>$rsclast,
				  'rtotdepositdulu' =>$rtotdepositdulu,
				  'rtotdeposittelp' =>$rtotdeposittelp,
				 'rtotdeposittelpdulu' =>$rtotdeposittelpdulu, 
				 'rtmpstdate' =>$rtmpstdate, 
				 'rtmpedate' =>$rtmpedate, 
				 'rfood' =>$rfood, 
				 'rfooddulu' =>$rfooddulu, 

               );    
			   
//$this->load->view('lareport/rptlapersonalrn', $data);

        $html=$this->load->view('lareport/rptlapersonalrn', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptlapersonal.pdf";
        //$this->m_pdf->pdf->SetFont('zaskiagothic');
		//$this->m_pdf->pdf->setFooter('{PAGENO}/{nbpg}');
		
		//$this->m_pdf->pdf->list_marker_offset = '5.5pt';
		//$this->m_pdf->pdf->list_symbol_size = '3.6pt';
		//$this->m_pdf->pdf->SetHTMLFooter($footer);
		//$this->m_pdf->pdf->AddPage('','A4','','',3,3,2,2,2,2,'P');
		//$this->m_pdf->pdf->SetHTMLHeader('<div style="text-align: left; ">No : '.$nolah.'</div><div style="text-align: right;">{PAGENO}</div>');
		if (strlen($rkomisaris['tgl_sign'])>0){
				$tgt=$rkomisaris['tgl_sign'];
		}else{
			$tgt=date('Y-m-d');
		}
		$tgttd = date('d F Y', strtotime($tgt));
		$this->m_pdf->pdf->SetHTMLHeader('<table width="100%"><tr><td align="left" style="font-size:10px">  '.''.'</td><td align="right" style="font-size:10px">'.''.'</td></tr></table>', 'O', true);
		
		$this->m_pdf->pdf->SetHTMLFooter('<table width="100%"><tr><td align="left" style="font-size:10px">'.$vshipname.'-No.'.$nolah.'</td><td align="right" style="font-size:10px">{PAGENO}/{nb}</td></tr></table>');
		$this->m_pdf->pdf->AddPage('P','','','','',30,30,30,20,20,10);
		$this->m_pdf->pdf->SetHTMLHeader('');
		$this->m_pdf->pdf->WriteHTML($html);
		ob_clean();
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        exit();
		
    }   
 
  function laprintpdf(){     
               $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link);   
				$pieces = explode("/",$loo_id); 
				$pieces2 = explode("-",$loo_id); 
				$rshortbranch=$this->model_lareport->qry_getbranchshort($loo_id);
				$branchsht=$rshortbranch['branch_nameshort'];
				$rshipname=$this->model_lareport->qry_getshipname($loo_id);
				$vshipname=$rshipname['rekananshipping_name'];
				
				$aromawi=substr($pieces[4],0,2);
				$atahun="20".$pieces2[1];
				
				$nola=$vshipname." - "." Nomor : ".$pieces[1]."/LA-".$branchsht."/A&D/".$pieces[3]."/".$aromawi."/".$atahun;
				$nolah=" Nomor : ".$pieces[1]."/LA-".$branchsht."/A&D/".$pieces[3]."/".$aromawi."/".$atahun;
				$rsewa=$this->model_lareport->qry_getsewa($loo_id);
				$nilsewa=$rsewa['agreementdetil_baserent'];
				$nilsewatotal=$rsewa['agreementdetil_totalleaseunitrate'];
				$rpercentdp=$this->model_lareport->qry_getpercendp($loo_id);
				$vpercentdp=$rpercentdp['agreementdetil_percent'];
				
				$rrpdp=$this->model_lareport->qry_getrupdp($loo_id);
				$vrpdp=$rrpdp['agreementdetil_mia'];
				
				
				$rinstaldp=$this->model_lareport->qry_getintdp($loo_id);
				$vinstaldp=$rinstaldp['instaldp'];
				
				$rconname=$this->model_lareport->qry_contactname($loo_id);
				$vconname=$rconname['rekanancontact_name'];
				
				$rlantai=$this->model_lareport->qry_getflbyid($loo_id);
				$vlantai=$rlantai['lantai_name'];
				
				
				
				$jumrentloi=$this->model_lareport->get_countrentloi($loo_id);
				$rtotdeposit=$this->model_lareport->get_totaldeposit($loo_id);
				if ($rtotdeposit['niltotal']>0){
				$rtotdeposit=$rtotdeposit['niltotal'];
				}else{
				$rtotdeposit=0;
				}
				
				$rtotrent=$this->model_lareport->get_totalrent($loo_id);
				$rtotrent=$rtotrent['totalrent'];
				$rcekarea=$this->model_lareport->get_cekarea($loo_id);
				$rkomisaris=$this->model_lareport->qry_strukturkomisaris($loo_id);
				
				$roin=$this->model_lareport->get_totalrentindoor($loo_id);
				$roin=$roin['totalrent'];
				$rout=$this->model_lareport->get_totalrentoutdoor($loo_id);
				$rout=$rout['totalrent'];
				
				
				

        $data   = array(
                  'result'    => $this->model_lareport->viewloo($loo_id),
				  'rloo'    => $this->model_lareport->get_loibyid($loo_id),
				  'rloi'    => $this->model_lareport->get_detilloirent($loo_id),
				  'rloirent'    => $this->model_lareport->get_detilloirentsingle($loo_id),				  
				  'rintservice' => $this->model_lareport->get_intvpelayanan($loo_id),	
				  'rnilaiservice' => $this->model_lareport->get_nilaipelayanan($loo_id),
				  'rnilaipromo' => $this->model_lareport->get_nilaipromosi($loo_id),	
				  'rkomisaris' => $this->model_lareport->qry_strukturkomisaris($loo_id),		
				   'rgplv' => $this->model_lareport->get_nilaigplv($loo_id),
				  'rfood' => $this->model_lareport->get_nilaifood($loo_id),   				  
				  'nilsewa'    =>$nilsewa,
				  'jumrentloi'    =>$jumrentloi['jumlah'],
				  'roin' => $roin,
				  'rout' => $rout,
				  'rtotdeposit' => $rtotdeposit,	
				  'rtotrent' => $rtotrent,	
				  'rcekarea' => $rcekarea,
				  'nilsewatotal'=>$nilsewatotal,
				  'nola'    => $nola,
				  'nolah'    => $nolah,
				  'vlantai' => $vlantai,
				  'vpercentdp' => $vpercentdp,
				  'vrpdp' => $vrpdp,
				  'vinstaldp' => $vinstaldp,
				  'vconname' => $vconname,			  
				  'vunit'    => $this->model_looprint->getunitloo($loo_id),
				  'rcekarea' => $rcekarea
                  
               );                 


$this->load->view('lareport/rptla', $data);

    /*    $html=$this->load->view('lareport/rptla', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptla.pdf";
		
		$this->m_pdf->param = '"P","A4","18","tahoma",4,3,3,3,0,0';
		$this->m_pdf->pdf->SetFont('tahoma');
        $this->m_pdf->pdf->WriteHTML($html);
		ob_clean();
        $this->m_pdf->pdf->Output($pdfFilePath, "I");    */
        
        
    }  
	
	function lacoverprint(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link);   
				$pieces = explode("/",$loo_id); 
				$pieces2 = explode("-",$loo_id); 
				$rshortbranch=$this->model_lareport->qry_getbranchshort($loo_id);
				$branchsht=$rshortbranch['branch_nameshort'];
				$rshipname=$this->model_lareport->qry_getshipname($loo_id);
				$vshipname=$rshipname['rekananshipping_name'];
				
				$aromawi=substr($pieces[4],0,2);
				$atahun="20".$pieces2[1];
				
				$nola=$pieces[1]."/LA-".$branchsht."/A&D/".$pieces[3]."/".$aromawi."/".$atahun;
				$nolah=$pieces[1]."/LA-".$branchsht."/A&D/".$pieces[3]."/".$aromawi."/".$atahun;
				$rsewa=$this->model_lareport->qry_getsewa($loo_id);
				$nilsewa=$rsewa['agreementdetil_baserent'];
				$nilsewatotal=$rsewa['agreementdetil_totalleaseunitrate'];
				$rpercentdp=$this->model_lareport->qry_getpercendp($loo_id);
				$vpercentdp=$rpercentdp['agreementdetil_percent'];
				
				$rrpdp=$this->model_lareport->qry_getrupdp($loo_id);
				$vrpdp=$rrpdp['agreementdetil_mia'];
				
				
				$rinstaldp=$this->model_lareport->qry_getintdp($loo_id);
				$vinstaldp=$rinstaldp['instaldp'];
				
				$rconname=$this->model_lareport->qry_contactname($loo_id);
				$vconname=$rconname['rekanancontact_name'];
				
				$rlantai=$this->model_lareport->qry_getflbyid($loo_id);
				$vlantai=$rlantai['lantai_name'];
				$vresult=$this->model_lareport->viewloo($loo_id);
				

        $data   = array(
                  'result'    => $this->model_lareport->viewloo($loo_id),
				  'rloo'    => $this->model_lareport->get_loibyid($loo_id),
				  'rloi'    => $this->model_lareport->get_detilloirent($loo_id),
				  'nola'    => $nola,
				  'nolah'    => $nolah,
				  'vlantai' => $vlantai,
				  'vpercentdp' => $vpercentdp,
				  'vrpdp' => $vrpdp,
				  'vinstaldp' => $vinstaldp,
				  'vconname' => $vconname,
				  'vunit'    => $this->model_looprint->getunitloo($loo_id)
                  
               );    
			   
foreach($vresult as $row){ 
$namabrch=$row->branch_namerpt;
}

        $html=$this->load->view('lareport/rptcover', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptcover.pdf";
      
	   
	   $this->m_pdf->pdf->SetHTMLFooter('<table width="100%"><tr><td align="center" style="font-size:10px"><b>'.$namabrch.'</b></td></tr></table>');
	   
		$this->m_pdf->pdf->AddPage('P','','','','',30,30,30,20,20,30);
		$this->m_pdf->pdf->WriteHTML($html);
		ob_clean();
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        exit();
    } 
	
	
	function laprintpdfpersonal(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link);   
				$pieces = explode("/",$loo_id); 
				$pieces2 = explode("-",$loo_id); 
				$nola=$pieces[1]."/LA-".$pieces[3]."/A&D/".$pieces[4]."/".$pieces2[1];

        $data   = array(
                  'result'    => $this->model_lareport->viewloo($loo_id),
				  'nola'    => $nola,
				   'vunit'    => $this->model_looprint->getunitloo($loo_id)
                  
               );                 

        $html=$this->load->view('lareport/rptlapersonal', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptlapersonal.pdf";
		
		$this->m_pdf->param = '"P","A4","18","tahoma",4,3,3,3,0,0';
		$this->m_pdf->pdf->SetFont('tahoma');
        $this->m_pdf->pdf->WriteHTML($html);
		ob_clean();
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        
        
    }  
	
	
	function lalist(){
        
        $loo_id = $this->uri->segment(4);
         
        $data   = array(
                  'result'    => $this->model_lareport->viewloorn($loo_id),
                  'loo_id'   => $loo_id
            );        

        
        $this->breadcrumbcomponent->add('LOO Lease Agreement Print','lareport/lalist');

        $this->load->view('template/v_header');
        $this->load->view('lareport/la_listrn', $data);
        $this->load->view('template/v_footer');
    }
		
		
		function globalsearch_list(){
		$arcari=array('a.loc_id',  'x.agreement_id');
		return $arcari;
	}
	
	
	function initialize_grid($qry_alldata,$qry_filtered,$qry_totalall,$arcari){
		$aColumns = $arcari;
     
    $sOrder = "";
    if ( isset( $_GET['iSortCol_0'] ) ) {
        $sOrder = "ORDER BY  ";
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ) {
            if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) {
                $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                    ".addslashes( $_GET['sSortDir_'.$i] ) .", ";
            }
        }
        $sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" ) {
            $sOrder = "";
        }
    }
       
    $sWhere = "";
    if ( isset($_POST['search']['value']) && $_POST['search']['value'] != "" ) {
       $sWhere = "WHERE (";
        for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
            $sWhere .= $aColumns[$i]." LIKE '%".addslashes( $_POST['search']['value'] )."%' OR ";
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
		
        $sWhere .= ')';
    } 
	 
    $top = (isset($_POST['start']))?((int)$_POST['start']):0 ;
    $limit = (isset($_POST['length']))?((int)$_POST['length'] ):10 ;
	$limit=$limit+$top;

    $rResult=$this->model_lareport->$qry_alldata($limit,$top,$sWhere);
	
	
   
	$rResultCnt =$this->model_lareport->$qry_filtered($sWhere);
	//$iFilteredTotal = $rResultCnt['jml'];
	$iFilteredTotal =$rResultCnt;

	$rResultTotal =$this->model_lareport->$qry_totalall();
	//$iTotal = $rResultTotal['jml'];
	$iTotal =$rResultTotal;
       
    $output = array(
        "draw"=> $_POST['draw'],
        "recordsTotal" => $iTotal,
        "recordsFiltered" => $iFilteredTotal,
        "data" => array()
    );
      $data['output']=$output;
	  $data['rResult']=$rResult;
	  
	return $data;
}

function controler_gridlist(){
        $arcari=$this->globalsearch_list();
        $vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {

            $i_link = str_replace('/', '_', $aRow['loo_id']);
            $ship_name = substr($aRow['rekanan_name'], 0, 15) . '...';
            $is_post = ($aRow['isconfirm']) ? 1 : 0;
            $is_post = ($aRow['isapproved']) ? 1 : 0;            
            
            $id_show =$aRow['loo_id']; 
			
            
            $row = array();
                    $row[]=$id_show;
                   // $row[]=date("d-m-Y", strtotime($aRow['loo_date']));
				   $row[]=$aRow['agreement_id'];
                    $row[]=date("d-m-Y", strtotime($aRow['loo_sdate']));
                    $row[]=date("d-m-Y", strtotime($aRow['loo_edate']));
                    $row[]=$aRow['loo_term'];
                    $row[]=$aRow['region_nameshort'];
                    $row[]=$aRow['branch_name'];
                    $row[]=$ship_name;
                    $row[]=$aRow['rekananshipping_name'];
                    $row[]=$aRow['isapproved'];
                    $row[]=$aRow['isconfirm'];	
					
					$rkn=substr($aRow['rekanan_name'],0,2);
					$rkn=strtoupper($rkn);
					if ( (trim($rkn)=='PT') or (trim($rkn)=='CV') ){
						$row[]='<a href="/index.php/lareport/lareport/lacoverprint/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank" class="btn btn-primary btn-xs">Cover</a>
						<a href="/index.php/lareport/lareport/laprintpdf/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank" class="btn btn-primary btn-xs">LA Perusahaan</a>
					<a href="/index.php/laprint5/laprint5/laprint5pdf/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank" class="btn btn-primary btn-xs">Apendik II</a>
					<a href="/index.php/laprint/laprint/la_printpdf/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank" class="btn btn-primary btn-xs">Apendik III</a>
					<a href="/index.php/laprint/laprint/la_ap_iv_printpdf/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank" class="btn btn-primary btn-xs">Apendik IV</a>
					<a href="/index.php/laprint5/laprint5/laprint7pdf/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank" class="btn btn-primary btn-xs">Eksibit A</a>
					<a href="/index.php/lareport/lainput_detil/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank" class="btn btn-primary btn-xs">Edit</a>
					';
					}else{
						$row[]='<a href="/index.php/lareport/lareport/lacoverprint/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank" class="btn btn-primary btn-xs">Cover</a>
						<a href="/index.php/lareport/lareport/lapersonalprint/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank" class="btn btn-primary btn-xs">LA Personnal</a>
					<a href="/index.php/laprint5/laprint5/laprint5pdf/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank" class="btn btn-primary btn-xs">Apendik II</a>
					<a href="/index.php/laprint/laprint/la_printpdf/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank" class="btn btn-primary btn-xs">Apendik III</a>
					<a href="/index.php/laprint/laprint/la_ap_iv_printpdf/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank" class="btn btn-primary btn-xs">Apendik IV</a>
					<a href="/index.php/lareport/lainput_detil/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank" class="btn btn-primary btn-xs">Edit</a>
					';
					
					}
				


        
            if (!empty($row)) { $output['data'][] = $row; }
        }   
        
        echo json_encode($output);
            
    }
	
	
function controler_gridlistrn(){
        $arcari=$this->globalsearch_list();
        $vResult=$this->initialize_grid("qry_alldatalistrn","qry_filteredlistrn","qry_totalalllistrn",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {

            $i_link = str_replace('/', '_', $aRow['loc_id']);
            $ship_name = substr($aRow['rekanan_name'], 0, 15) . '...';
            $is_post = ($aRow['isconfirm']) ? 1 : 0;
            $is_post = ($aRow['isapproved']) ? 1 : 0;            
            
            $id_show =$aRow['loc_id']; 
			
            
            $row = array();
                    $row[]=$id_show;
                   // $row[]=date("d-m-Y", strtotime($aRow['loo_date']));
				   $row[]=$aRow['agreement_id'];
                    $row[]=date("d-m-Y", strtotime($aRow['loc_sdate']));
                    $row[]=date("d-m-Y", strtotime($aRow['loc_edate']));
                    $row[]=$aRow['loc_term'];
                    $row[]=$aRow['region_nameshort'];
                    $row[]=$aRow['branch_name'];
                    $row[]=$ship_name;
                    $row[]=$aRow['rekananshipping_name'];
                    $row[]=$aRow['isapproved'];
                    $row[]=$aRow['isconfirm'];	
					
					$rkn=substr($aRow['rekanan_name'],0,2);
					$rkn=strtoupper($rkn);
					if ( (trim($rkn)=='PT') or (trim($rkn)=='CV') ){
						$row[]='<a href="/index.php/lareport/lareport/lacoverprintloc/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank" class="btn btn-primary btn-xs">Cover</a>
						<a href="/index.php/lareport/lareportrn/lapersonalprintrn/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank" class="btn btn-primary btn-xs">LA Perusahaan</a>
					<a href="/index.php/lareport/lareportrn/lainput_detilloc/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank" class="btn btn-primary btn-xs">Edit</a>
					';
					}else{
						$row[]='<a href="/index.php/lareport/lareport/lacoverprintloc/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank" class="btn btn-primary btn-xs">Cover</a>
						<a href="/index.php/lareport/lareportrn/lapersonalprintrn/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank" class="btn btn-primary btn-xs">LA Personnal</a>
					
					<a href="/index.php/lareport/lareportrn/lainput_detilloc/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank" class="btn btn-primary btn-xs">Edit</a>
					';
					
					}
				


        
            if (!empty($row)) { $output['data'][] = $row; }
        }   
        
        echo json_encode($output);
            
    }
	
}  