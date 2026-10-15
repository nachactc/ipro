<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class simpay extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();

        $this->load->library('breadcrumbcomponent');
        
        $this->load->model('model_simpay');        
        //$this->load->model('model_smprint');

    }

    function index(){

      //$data['agreement'] = $this->model_proforma->get_agreement();

      //$this->view('content/phpexcel', $data);
      redirect('simpay/simpay/sim_view');

    }    
	
    function sim_view(){ 

      $data=array(
        'space_val'     => '',
        'term_val'      => '',
        'baserent_val'  => '',
        'dp_val'        => '',
        'payterm_val'   => '',
        'xtotal'        => array(),
        'ytotal'        => array(),      
        'collabel'      => array(), 
        'rowlabel'      => array(),
        'zcross_tab'    => array(),
        'total_rent'    => '',        
        'dp_fee_per'    => '',
        'dp_arp_per'    => '',
        'dp_fee_val'    => '',
        'dp_arp_val'    => '',
        'angsuran_bln'  => '',
        'payment_bln'   => '',
        'sc_baserent'   => '',
        'sc_val'        => '',        
        'pl_baserent'   => '',
        'pl_val'        => '',
        'depo_rent'     => '',
        'depo_sc'       => '',
        'depo_rent_val' => '',
        'depo_sc_val'   => '',        
        'tenant_val'    => '',
        'branch_id'     => '',
        'branch_val'    => '',
        'sim_id'        => ''
      ); 

      $this->breadcrumbcomponent->add('Simulasi Schedule Payment','simpay/simpay/sim_view');
      $this->load->view('template/v_header');                         
      $this->load->view('simpay/v_simpay',$data);
      $this->load->view('template/v_footer');

    } 

    function sim_generate(){

      $x = 0;
      $y = 0;
      $total_dp = 0;
      $mia = 0;
      $koe = 0;

      $_space       = str_replace(',', '', $this->input->post('sim_space'));
      $_term        = str_replace(',', '', $this->input->post('sim_term'));
      $_baserent    = str_replace(',', '', $this->input->post('sim_baserent'));      
      $_payterm     = str_replace(',', '', $this->input->post('sim_payterm'));
      $_dp_fee      = str_replace(',', '', $this->input->post('sim_fee_per'));
      $_dp_arp      = str_replace(',', '', $this->input->post('sim_arp_per'));
      $_sc_rent     = str_replace(',', '', $this->input->post('sim_sc'));
      $_pl_rent     = str_replace(',', '', $this->input->post('sim_pl'));
      $_depo_rent   = str_replace(',', '', $this->input->post('sim_depo_rent'));
      $_depo_sc     = str_replace(',', '', $this->input->post('sim_depo_sc'));
      $_tenant      = str_replace(',', '', $this->input->post('sim_tenant'));
      $id_branch    = str_replace(',', '', $this->input->post('ibranch'));
      $name_branch  = str_replace(',', '', $this->input->post('branch_name'));      
      $_id  = str_replace(',', '', $this->input->post('sim_id'));
   
   
      $total_dp     = ($_dp_fee + $_dp_arp); /** Persiapan kedepan jika ada libih dari 2 DP **/

      $arr_return = $this->rental_calculation ($total_dp, $_space, $_term, $_baserent, $_payterm, 
        $_dp_fee, $_dp_arp, $_sc_rent, $_pl_rent, $_depo_rent, $_depo_sc);
      
      //print_r($arr_return); exit;   
      $data=array(
        'space_val'     => $_space,
        'term_val'      => $_term,
        'baserent_val'  => $_baserent,              
        'payterm_val'   => $_payterm,
        'xtotal'        => $arr_return['xTotal'],
        'ytotal'        => $arr_return['yTotal'],      
        'collabel'      => $arr_return['collabel'], 
        'rowlabel'      => $arr_return['rowlabel'],
        'zcross_tab'    => $arr_return['zcross_tab'],
        'total_rent'    => $arr_return['total_rent'],
        'dp_fee_per'    => $_dp_fee,
        'dp_arp_per'    => $_dp_arp,
        'dp_fee_val'    => $arr_return['dp_fee_val'],
        'dp_arp_val'    => $arr_return['dp_arp_val'],
        'angsuran_bln'  => $arr_return['angsuran_bln'],
        'payment_bln'   => $arr_return['payment_bln'],
        'sc_baserent'   => $_sc_rent,
        'sc_val'        => $arr_return['sc_val'],        
        'pl_baserent'   => $_pl_rent,
        'pl_val'        => $arr_return['pl_val'],        
        'depo_rent'     => $_depo_rent,
        'depo_sc'       => $_depo_sc,
        'depo_rent_val' => $arr_return['depo_rent_val'],
        'depo_sc_val'   => $arr_return['depo_sc_val'],      
        'tenant_val'    => $_tenant,
        'branch_id'     => $id_branch,
        'branch_val'    => $name_branch,
        'sim_id'        => $_id
      ); 
 
      $this->breadcrumbcomponent->add('Simulasi Schedule Payment','simpay/simpay/sim_view');
      $this->load->view('template/v_header');
      $this->load->view('simpay/v_simpay',$data);
      $this->load->view('template/v_footer');    
    }        

    function loo_select(){

        $rSearch = empty($_GET['term']) ? '' : $_GET['term'];

        if (is_array($rSearch) && $rSearch['_type'] == 'query'){            
            
            $loo     = $this->model_simpay->get_loobyquery($rSearch['term']);
            
            $result['items']= $loo;
          
            echo json_encode($result);
            
        };
    }

    function tenant_select(){

        $rSearch = empty($_GET['term']) ? '' : $_GET['term'];

        if (is_array($rSearch) && $rSearch['_type'] == 'query'){            
            
            $tenant     = $this->model_simpay->get_tenantbyquery($rSearch['term']);
            
            $result['items']= $tenant;
          
            echo json_encode($result);
            
        };
    }

    function sim_select(){

        $rSearch = empty($_GET['term']) ? '' : $_GET['term'];

        if (is_array($rSearch) && $rSearch['_type'] == 'query'){            
            
            $loo     = $this->model_simpay->get_simbyquery($rSearch['term']);
            
            $result['items']= $loo;
          
            echo json_encode($result);
            
        };
    }

    function sim_save(){   

      if ($_POST){

            $output = $_POST['data'];

            parse_str($_POST['data'], $output);
            //print_r(($output)); exit;

            $_id            = $output['sim_id'];
            $type           = $output['itype'];
            $space          = $output['sim_space'];
            $term           = $output['sim_term'];
            $payterm        = $output['sim_payterm'];
            $baserent       = $output['sim_baserent'];
            $totalrent      = $output['sim_totalrent'];
            $fee_per        = $output['sim_fee_per'];
            $fee_val        = $output['sim_fee_val'];
            $arp_per        = $output['sim_arp_per'];
            $arp_val        = $output['sim_arp_val'];
            $sc             = $output['sim_sc'];
            $sc_val         = $output['sim_sc_val'];
            $pl             = $output['sim_pl'];
            $pl_val         = $output['sim_pl_val'];
            $angsuran_bln   = $output['sim_angsuran'];
            $payment_bln    = $output['sim_payment'];
            $depo_rent      = $output['sim_depo_rent'];
            $depo_rent_val  = $output['sim_depo_rent_val'];
            $depo_sc        = $output['sim_depo_sc'];
            $depo_sc_val    = $output['sim_depo_sc_val'];
            $tenant_val     = $output['sim_tenant'];
            $branch_id      = $output['ibranch'];            
            $_createby      = $this->session->userdata('username');
            //$tenant         = $output['21']['value'];
            //$brand          = $output['22']['value'];
            
            $_success = $this->model_simpay->insertsim($_id, $type, $space, $term, $payterm, $baserent, $totalrent, 
                $fee_per, $fee_val, $arp_per, $arp_val, $sc, $sc_val, $pl, $pl_val, $angsuran_bln, $payment_bln, 
                $depo_rent, $depo_sc, $depo_rent_val, $depo_sc_val, $tenant_val, $branch_id, $_createby);

            if ($_success)
            {
                $result['success'] = TRUE;
            }else{
                $result['success'] = FALSE;
            }

            $result['data'] = array('id' => $_id);

            echo json_encode($result);

      };


    }

    function sim_load(){

        $_id = empty($_GET['id']) ? '' : $_GET['id'];        

        $rResult = $this->model_simpay->load_sim($_id);        

        foreach ($rResult as $aRow) {

            $row = array();             
            $row[]=$aRow['rekanan_id'];
            $row[]=$aRow['rekananshipping_line'];
            $row[]=$aRow['sim_space'];
            $row[]=$aRow['sim_term'];
            $row[]=$aRow['sim_payterm'];
            $row[]=$aRow['sim_baserent'];
            $row[]=$aRow['sim_totalrent'];
            $row[]=$aRow['sim_fee_per'];
            $row[]=$aRow['sim_fee_val'];
            $row[]=$aRow['sim_arp_per'];
            $row[]=$aRow['sim_arp_val'];
            $row[]=$aRow['sim_sc'];
            $row[]=$aRow['sim_sc_val'];
            $row[]=$aRow['sim_pl'];
            $row[]=$aRow['sim_pl_val'];
            $row[]=$aRow['sim_angsuran'];
            $row[]=$aRow['sim_payment'];
            $row[]=$aRow['sim_depo_rent'];
            $row[]=$aRow['sim_depo_sc'];
            $row[]=$aRow['sim_depo_rent_val'];
            $row[]=$aRow['sim_depo_sc_val'];
            $row[]=$aRow['sim_tenant'];
            $row[]=$aRow['branch_id'];
            $row[]=$aRow['branch_name'];                      
            $row[]=$aRow['loo_id']; 

        if (!empty($row)) { $output['data'][] = $row; }
        }   
        
        echo json_encode($output); 

    } 

    function sim_print(){  


            $_type        = str_replace(',', '', $this->input->post('itype'));
            $_space       = str_replace(',', '', $this->input->post('sim_space'));
            $_term        = str_replace(',', '', $this->input->post('sim_term'));
            $_baserent    = str_replace(',', '', $this->input->post('sim_baserent'));      
            $_payterm     = str_replace(',', '', $this->input->post('sim_payterm'));
            $_dp_fee      = str_replace(',', '', $this->input->post('sim_fee_per'));
            $_dp_arp      = str_replace(',', '', $this->input->post('sim_arp_per'));
            $_sc_rent     = str_replace(',', '', $this->input->post('sim_sc'));
            $_pl_rent     = str_replace(',', '', $this->input->post('sim_pl'));
            $_depo_rent   = str_replace(',', '', $this->input->post('sim_depo_rent'));
            $_depo_sc     = str_replace(',', '', $this->input->post('sim_depo_sc'));  
            $_totalrent   = str_replace(',', '', $this->input->post('sim_totalrent'));  
            $_fee_val     = str_replace(',', '', $this->input->post('sim_fee_val'));  
            $_arp_val     = str_replace(',', '', $this->input->post('sim_arp_val'));  
            $_sc_val      = str_replace(',', '', $this->input->post('sim_sc_val'));  
            $_pl_val      = str_replace(',', '', $this->input->post('sim_pl_val'));  
            $_angsuran    = str_replace(',', '', $this->input->post('sim_angsuran'));  
            $_payment     = str_replace(',', '', $this->input->post('sim_payment'));  
          
            $form[] = (object) array(
                'itype'           => $_type,
                'sim_space'       => $_space,
                'sim_term'        => $_term,
                'sim_payterm'     => $_payterm,
                'sim_baserent'    => $_baserent,
                'sim_totalrent'   => $_totalrent,
                'sim_fee_per'     => $_dp_fee,
                'sim_fee_val'     => $_fee_val,
                'sim_arp_per'     => $_dp_arp,
                'sim_arp_val'     => $_arp_val,
                'sim_sc'          => $_sc_rent,
                'sim_sc_val'      => $_sc_val,
                'sim_pl'          => $_pl_rent,
                'sim_pl_val'      => $_pl_val,
                'sim_angsuran'    => $_angsuran,
                'sim_payment'     => $_payment,
                'sim_depo_rent'   => $_depo_rent,
                'sim_depo_sc'     => $_depo_sc
            );    

            $total_dp   = ($_dp_fee + $_dp_arp);

            //$data['form']     = $form;
            $arr_return = $this->rental_calculation ($total_dp, $_space, $_term, $_baserent, $_payterm, 
                $_dp_fee, $_dp_arp, $_sc_rent, $_pl_rent, $_depo_rent, $_depo_sc);

            $data=array(

                'xtotal'        => $arr_return['xTotal'],
                'ytotal'        => $arr_return['yTotal'],      
                'collabel'      => $arr_return['collabel'], 
                'rowlabel'      => $arr_return['rowlabel'],
                'zcross_tab'    => $arr_return['zcross_tab'],
                'total_rent'    => $arr_return['total_rent']                
            ); 

            $data['form']     = $form;      

            //$this->load->view('simpay/p_simpay', $data);

            $html=$this->load->view('simpay/p_simpay', $data, TRUE);
            $this->load->library('m_pdf');
            $pdfFilePath = "p_simpay.pdf";

            $this->m_pdf->pdf->simpleTables = true;

            $this->m_pdf->pdf->packTableData = true;

            $this->m_pdf->pdf->AddPage('P','','','','',30,10,25,15,8,8);
            $this->m_pdf->pdf->WriteHTML($html);       
            $this->m_pdf->pdf->Output($pdfFilePath, "I");      

    }

    function rental_calculation ($total_dp, $_space, $_term, $_baserent, $_payterm, $_dp_fee, $_dp_arp, 
        $_sc_rent, $_pl_rent, $_depo_rent, $_depo_sc) {        

        $x = 0;
        $y = 0;
        $mia = 0;
        $koe = 0;

        $_tlv         = ($_space * $_term * $_baserent);
        $_tlv_pay     = ($_space * $_payterm * $_baserent);

        if ($_tlv_pay > 0) {
          $koe          = $_tlv / $_tlv_pay;      
        }

        $_dp_fee_val  = ($_tlv * ($_dp_fee/100));

        $_dp_arp_val  = ($_tlv * ($_dp_arp/100));

        $dpamount     = ($_tlv * ($total_dp/100));

        $_sc_val        = ($_space * $_sc_rent);
        $_pl_val        = ($_space * $_pl_rent);
        $depo_rent_val  = ($_baserent * $_space * $_depo_rent);
        $depo_sc_val    = ($_sc_rent * $_space * $_depo_sc);

        $depo         = ($depo_rent_val + $depo_sc_val);

        if ($_term > 0){
          $mia          = (($_tlv * (100-$total_dp)/100) / $_term) * $koe;      
        }

        $x_row        = array();
        $y_col        = array();
        $zcross_tab   = array();
        $xTotal       = array();
        $yTotal       = array();

        $x_row['1'][]                       = $dpamount;
        $y_col['Down Payment'][]            = $dpamount;
        $zcross_tab['Down Payment'.'_'.'1'] = $dpamount;

        $x_row['1'][]                           = $depo;
        $y_col['Security Deposit'][]            = $depo;
        $zcross_tab['Security Deposit'.'_'.'1'] = $depo;

        while($x < $_payterm){

          $y = $x+1;
          $x_row[$y][]                      = $mia;
          $y_col['Installment'][]           = $mia;
          $zcross_tab['Installment'.'_'.$y] = $mia;

          $x_row[$y][]                            = $_sc_val;
          $y_col['Service Charge'][]              = $_sc_val;  
          $zcross_tab['Service Charge'.'_'.$y]    = $_sc_val;

          $x_row[$y][]                            = $_pl_val;
          $y_col['Promotion Levy'][]              = $_pl_val;  
          $zcross_tab['Promotion Levy'.'_'.$y]    = $_pl_val;

          $x++;

        }

        foreach($x_row as $id => $amount){
            $rowLabel[]   = $id;
            $xTotal[$id]  = array_sum($amount);
        }

        foreach($y_col as $id => $amount){  
            $colLabel[]   = $id;          
            $yTotal[$id]  = array_sum($amount);
        }

        $_payment_bln     = ($mia + $_sc_val + $_pl_val);


        $arr = array (

            'xTotal'          => $xTotal,
            'yTotal'          => $yTotal,
            'collabel'        => $colLabel,
            'rowlabel'        => $rowLabel,
            'zcross_tab'      => $zcross_tab,
            'total_rent'      => $_tlv,
            'dp_fee_val'      => $_dp_fee_val,
            'dp_arp_val'      => $_dp_arp_val,
            'angsuran_bln'    => $mia,
            'payment_bln'     => $_payment_bln,
            'sc_val'          => $_sc_val,
            'pl_val'          => $_pl_val,
            'depo_rent_val'   => $depo_rent_val,
            'depo_sc_val'     => $depo_sc_val,

        );

      return $arr;
    }

    function branch_select(){

        $rSearch = empty($_GET['term']) ? '' : $_GET['term'];
        //$rRegion = empty($_GET['region']) ? '' : $_GET['region'];

        if (is_array($rSearch) && $rSearch['_type'] == 'query'){            

            $this->load->model('template/Master_m');
            
            $branch      = $this->Master_m->get_branchbyall($rSearch['term']);
            
            $result['items']= $branch;
          
            echo json_encode($result);
            
        };
    }

}  