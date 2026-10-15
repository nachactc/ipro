<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
 


class Dashboard extends MX_Controller
{

    public function __construct() 
    {
        parent::__construct(); 
		check_user_login();        
        $this->load->model('Model_dashboard');  
		$this->load->library('breadcrumbcomponent');  
		$this->breadcrumbcomponent->add('Dashboard Detil Reminder','Dashboard');
    }
     

    /**
    * List all data master_rekanan
    *
    */
    public function index() 
    {
        $data = array();
		 
		$data = $this->dataReminder();
		$data = $data + $this->dataStatusLoo();
		$data = $data + $this->dataSumSecDep();
		//$data = $data + $this->get_tenant_status(); 
		$data = $data + $this->dataStatusLoi(); 
		$data = $data + $this->dataStatusInvoicePayment(); 
		$data = $data + $this->dataStatusInvoicePayment_Outstanding(); 
		 
		
        $this->load->view('template/v_header');
        $this->load->view('dashboard/view', $data);
        $this->load->view('template/v_footer');
	      
    }
	
    protected function dataReminder()
	{
		$data = array();
		//reminder agreement 
		$data['reminder_1bln'] = $this->Model_dashboard->get_reminder1bln();
		$data['reminder_3bln'] = $this->Model_dashboard->get_reminder3bln();
		$data['reminder_6bln'] = $this->Model_dashboard->get_reminder6bln();
		$data['reminder_12bln'] = $this->Model_dashboard->get_reminder12bln();
		//link
		$data['link_1bln'] = site_url('dashboard/ReminderDetil/1');
		$data['link_3bln'] = site_url('dashboard/ReminderDetil/3');
		$data['link_6bln'] = site_url('dashboard/ReminderDetil/6');
		$data['link_12bln'] =site_url('dashboard/ReminderDetil/12');
		return $data;
	}	
	
	public function ReminderDetil($bln,$excel=FALSE)
	{ 
		$data['detil_bln'] = $this->Model_dashboard->get_reminderbln_detil($bln); 
		$data['excel'] = $excel; 
		if($excel == FALSE)
		{
			$this->load->view('template/v_header'); 
		}
        $this->load->view('dashboard/view_reminder', $data);
		if($excel == FALSE)
		{
			$this->load->view('template/v_footer');
		}
	}
	  
	protected function dataStatusLoo()
	{
		$data = array();
		//status data loi
		
		//region 120 trp
		$data['approveLoo_trp'] = $this->Model_dashboard->get_dataApproveLoo('120');
		$data['dataBaruLoo_trp'] = $this->Model_dashboard->get_dataBaruLoo('120');
		$data['dataLooProcess_trp'] = $this->Model_dashboard->get_dataLoiProcess('120');
		$data['dataLooSent_trp'] = $this->Model_dashboard->get_dataLoiSent('120');
		$data['dataLooSign_trp'] = $this->Model_dashboard->get_dataLoiSign('120');
		$data['dataLooRcv_trp'] = $this->Model_dashboard->get_dataLoiReceived('120');
		$data['dataLooAll_trp'] = $this->Model_dashboard->get_allDataBaruLoo('120');
		//region 030 tri 
		$data['approveLoo_tri'] = $this->Model_dashboard->get_dataApproveLoo('030');
		$data['dataBaruLoo_tri'] = $this->Model_dashboard->get_dataBaruLoo('030');
		$data['dataLooProcess_tri'] = $this->Model_dashboard->get_dataLoiProcess('030');
		$data['dataLooSent_tri'] = $this->Model_dashboard->get_dataLoiSent('030');
		$data['dataLooSign_tri'] = $this->Model_dashboard->get_dataLoiSign('030');
		$data['dataLooRcv_tri'] = $this->Model_dashboard->get_dataLoiReceived('030');
		$data['dataLooAll_tri'] = $this->Model_dashboard->get_allDataBaruLoo('030');
		//region 050 ari
		$data['approveLoo_ari'] = $this->Model_dashboard->get_dataApproveLoo('050');
		$data['dataBaruLoo_ari'] = $this->Model_dashboard->get_dataBaruLoo('050');
		$data['dataLooProcess_ari'] = $this->Model_dashboard->get_dataLoiProcess('050');
		$data['dataLooSent_ari'] = $this->Model_dashboard->get_dataLoiSent('050');
		$data['dataLooSign_ari'] = $this->Model_dashboard->get_dataLoiSign('050');
		$data['dataLooRcv_ari'] = $this->Model_dashboard->get_dataLoiReceived('050');
		$data['dataLooAll_ari'] = $this->Model_dashboard->get_allDataBaruLoo('050');
		
		return $data;
		
	}
	
	protected function dataStatusLoi()
	{
		$data = array();
		//status data loi
		
		 
		$data['loi'] = $this->Model_dashboard->get_status_loi();
		 
		
		return $data;
		
	}
	
	protected function dataSumSecDep()
	{
		$data = array(); 
		$data['SumShopMall_trp'] = $this->Model_dashboard->get_sumDP_Secdep('120'); 
		$data['SumShopMall_tri'] = $this->Model_dashboard->get_sumDP_Secdep('030'); 
		$data['SumShopMall_ari'] = $this->Model_dashboard->get_sumDP_Secdep('050');
 	
		return $data;
	}	
	 
	public function data_bar_chart()
	{
		//sudah di invoicing
		//belum di invoicing
		//sudah di invoicing dan di bayar
		//sudah di invoicing dan belum di bayar
		
		//unit 0 kosong,2 isi, 3 doc sudah di return
		//120 trp 030 tri 050 ari
		$unit_tri_kosong = $this->Model_dashboard->get_unitStatus('030',0);
		$unit_tri = $this->Model_dashboard->get_unitStatus('030',2); 
		$unit_trp_kosong = $this->Model_dashboard->get_unitStatus('120',0);
		$unit_trp = $this->Model_dashboard->get_unitStatus('120',2); 
		$unit_ari_kosong = $this->Model_dashboard->get_unitStatus('050',0);
		$unit_ari = $this->Model_dashboard->get_unitStatus('050',2); 
		
		$prefix = '';
		
		echo "[\n";
		  
		  echo $prefix . " {\n";
		  echo '  "category": "(TRI) Unit Available",' . "\n";  
		  echo '  "value1": '.$unit_tri_kosong.',' . "\n"; 
		  echo " }";
		  $prefix = ",\n";
		  
		  echo $prefix . " {\n";
		  echo '  "category": "(TRI) Unit Filled",' . "\n";  
		  echo '  "value2": '.$unit_tri.',' . "\n"; 
		  echo " }";
		  $prefix = ",\n";
		  
		  echo $prefix . " {\n";
		  echo '  "category": "(TRP) Unit Available",' . "\n";  
		  echo '  "value1": '.$unit_trp_kosong.',' . "\n"; 
		  echo " }";
		  $prefix = ",\n";
		  
		  echo $prefix . " {\n";
		  echo '  "category": "(TRP) Unit Filled",' . "\n";  
		  echo '  "value2": '.$unit_trp.',' . "\n"; 
		  echo " }";
		  $prefix = ",\n";
		  
		  echo $prefix . " {\n";
		  echo '  "category": "(ARI) Unit Available",' . "\n";  
		  echo '  "value1": '.$unit_ari_kosong.',' . "\n"; 
		  echo " }";
		  $prefix = ",\n";
		  
		  echo $prefix . " {\n";
		  echo '  "category": "(ARI) Unit Filled",' . "\n";  
		  echo '  "value2": '.$unit_ari.',' . "\n"; 
		  echo " }";
		  $prefix = ",\n";
		  
		 
		 
		echo "\n]";
	}

	public function get_tenant_status()
	{
		$data = array();
		
		$data['nik'] = $this->Model_dashboard->get_status_empty('master_rekanan','rekanan_taxnik'); 
		$data['link_nik_detil'] = '/index.php/dashboard/get_tenant_status_detil/nik'; 
		$json['country'] = 'Nik'; 
		$json['litres'] = $data['nik'];
		$json['url'] = $data['link_nik_detil']; 
		$output1 =  json_encode($json); 
		
		$data['taxsign_id'] = $this->Model_dashboard->get_status_empty('master_rekanan','taxsign_id'," OR taxsign_id = '0'");	
		$data['taxsign_id_detil'] = '/index.php/dashboard/get_tenant_status_detil/taxsign_id';
		$json['country'] = 'NPWP';
		$json['litres'] = $data['taxsign_id'];
		$json['url'] = $data['taxsign_id_detil']; 
		$output2 =  json_encode($json); 
		
		$data['email'] = $this->Model_dashboard->get_status_empty('master_rekananshipping','rekananshipping_contactemail'," OR rekananshipping_contactemail = ''");
		$data['link_email_detil'] = '/index.php/dashboard/get_tenant_status_detil/email';
		$json['country'] = 'Email';
		$json['litres'] = $data['email'];
		$json['url'] = $data['link_email_detil'];
		$output3 =  json_encode($json); 
		
		$data['hp'] = $this->Model_dashboard->get_status_empty('master_rekananshipping','rekananshipping_contacthp'," OR rekananshipping_contacthp = ''");
		$data['link_hp_detil'] = '/index.php/dashboard/get_tenant_status_detil/hp';
		$json['country'] = 'HP';
		$json['litres'] = $data['hp'];
		$json['url'] = $data['link_hp_detil'];
		$output4 =  json_encode($json); 
		
		$data['alamat'] = $this->Model_dashboard->get_status_empty('master_rekananshipping','rekananshipping_address'," OR rekananshipping_address = ''");
		$data['link_address_detil'] = '/index.php/dashboard/get_tenant_status_detil/alamat';
		$json['country'] = 'Address';
		$json['litres'] = $data['alamat'];
		$json['url'] = $data['link_address_detil'];
		$output5 =  json_encode($json); 
		
		$data['pic'] = $this->Model_dashboard->get_status_empty('master_rekananshipping','rekananshipping_contactname'," OR rekananshipping_contactname = ''");
		$data['link_pic_detil'] = '/index.php/dashboard/get_tenant_status_detil/pic'; 
		$json['country'] = 'PIC';
		$json['litres'] = $data['pic'];
		$json['url'] = $data['link_pic_detil'];
		$output6 = json_encode($json);
		
		// $output = '['.$output.','.$output.','.$output.','.$output.','.$output.','.$output.','.json_encode($output).']';  
		$output = '['.$output1.','.$output2.','.$output3.','.$output4.','.$output5.','.$output6.']';  
		//$output = '['.$output1.']';
		//return $data;
		echo $output;
	}
	
	public function get_tenant_status_detil($mode='')
	{
		$data = array();
		$rekanan = "rekanan_id as id,rekanan_name as name,rekanan_taxnik as nik ,'' as email, '' as hp,'' as address,'' as pic";
		$rekananshipping = "rekanan_id as id,rekananshipping_name as name,'' as nik, rekananshipping_contactemail as email,rekananshipping_contacthp as hp,rekananshipping_address as address,rekananshipping_contactname as pic";
		if($mode == 'nik')
		{
			$data['valueObject'] = $this->Model_dashboard->get_status_empty_detil('master_rekanan',$rekanan,'rekanan_taxnik');
		}
		elseif($mode == 'taxsign_id')
		{
			$data['valueObject'] = $this->Model_dashboard->get_status_empty_detil('master_rekanan',$rekanan,'taxsign_id'," OR taxsign_id = '0'");
		}
		elseif($mode == 'email')
		{
			$data['valueObject'] = $this->Model_dashboard->get_status_empty_detil('master_rekananshipping',$rekananshipping,'rekananshipping_contactemail'," OR rekananshipping_contactemail = ''");
		}
		elseif($mode == 'hp')
		{
			$data['valueObject'] = $this->Model_dashboard->get_status_empty_detil('master_rekananshipping',$rekananshipping,'rekananshipping_contacthp'," OR rekananshipping_contacthp = ''");
		}
		elseif($mode == 'alamat')
		{
			$data['valueObject'] = $this->Model_dashboard->get_status_empty_detil('master_rekananshipping',$rekananshipping,'rekananshipping_address'," OR rekananshipping_address = ''");
		}
		elseif($mode == 'pic')
		{
			$data['valueObject'] = $this->Model_dashboard->get_status_empty_detil('master_rekananshipping',$rekananshipping,'rekananshipping_contactname'," OR rekananshipping_contactname = ''");
		}
		$this->load->view('template/v_header'); 
		$this->load->view('dashboard/view_tenant_status', $data);
		$this->load->view('template/v_footer'); 
	}
	
	public function data_status_agreement()
	{ 
		$data = array();
		$data['month'] = date('M', strtotime('-1 month', time())).'-'.date('Y', strtotime('-1 month', time())); 
		$data['total'] = $this->Model_dashboard->get_status_agreement_posting(1);
		$a =  json_encode($data); 
		$data['month'] =  date("M").'-'.date("Y") ;
		$data['total'] = $this->Model_dashboard->get_status_agreement_posting(0); 
		$a =  '['.$a.','.json_encode($data).']';  
		echo $a; 
	}
	
	public function data_status_invoice()
	{
		$data = array();
		$data['month'] = 'Non-Proforma'; 
		$data['total'] = $this->Model_dashboard->get_status_invoice(0); 
		$a =  json_encode($data); 
		$data['month'] =  'Proforma' ;
		$data['total'] = $this->Model_dashboard->get_status_invoice(1); 
		$a =  '['.$a.','.json_encode($data).']';  
		echo $a; 
	}
	
	protected function dataStatusInvoicePayment()
	{
		$data = array();
		//status data loi
		
		 
		$data['total_invoice'] = $this->Model_dashboard->get_status_payment_invoice()->total_invoice;
		$data['payment_invoice'] = $this->Model_dashboard->get_status_payment_invoice()->payment_invoice;
		 
		
		return $data;
		
	} 
	protected function dataStatusInvoicePayment_Outstanding()
	{
		$data = array();
		//status data loi
		
		 
		$data['outstanding'] = $this->Model_dashboard->get_status_payment_invoice_2()->outstanding;
		$data['total_outstanding'] = $this->Model_dashboard->get_status_payment_invoice_2()->total_outstanding;
		 
		
		return $data;
		
	} 
}

?>
