<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Print_or extends CI_Controller
{

    function __construct()
    {

        parent::__construct();
        // Check login and make sure email has been verified
        check_user_login();

        $this
            ->load
            ->model('model_or');
        $this
            ->load
            ->library('breadcrumbcomponent');
        $this
            ->load
            ->library('form_validation');
    }
   
    public function test_view()
	{
		$this->load->view('print_or/or_mall');
	}
	
	public function report_mall($jurnal_id)
	{
		if(empty($jurnal_id) or $jurnal_id == ' ')
		{
			return false;
		}
		if(strlen($jurnal_id)< 12)
		{
			return false;
		}
		$data = array();
		$data_ref_func = array();
		$header_data = $this->model_or->get_header($jurnal_id);
		$detil_data = $this->model_or->get_detil($jurnal_id);
		$bilyet_data = $this->model_or->get_bilyet($jurnal_id);

		if( $header_data->jurnal_source == 'OR-ListSA'){
			$data['title'] = 'OFFICIAL RECEIPT MALL';
         $data['payment'] = 'Receipt Voucher';
		} elseif ($header_data->jurnal_source == 'RF-ListSD' || $header_data->jurnal_source == 'RF-ListTN'){
         $data['title'] = 'REFUND DEPOSIT';	
         $data['payment'] = 'Refund';
		} else {
         $data['title'] = '';	
         $data['payment'] = '';
      }
		
		$data['jurnal_id'] = $jurnal_id;
      $references = '';
		$data['ref'] = '';

      //$data['approval'] = $this->get_data_approval('RF');
		$data['approval'] = $this->model_or->get_approval('REFUND');

		if($header_data <> 'kosong')
		{
			$data['header'] = $header_data;
		}
		else
		{
			$data['header'] = array();
		}
		if($detil_data <> 'kosong')
		{
			$data['detil'] = $detil_data;
			$data['bilyet'] = $bilyet_data;

         foreach($detil_data as $row => $ref){
            if ($ref->ref_id==='') continue;
            $references .= $ref->ref_id . ", ";
         }
		}
		else
		{
			$data['detil'] = array();
		}
		// echo "<pre/>";
		// echo var_dump($data_ref_func); 
		// exit;

		$data['ref'] = $references; 
		$this->load->view('print_or/or_mall',$data); 
		
	}

   public function report_deposit($jurnal_id)
	{
		if(empty($jurnal_id) or $jurnal_id == ' ')
		{
			return false;
		}
		if(strlen($jurnal_id)< 12)
		{
			return false;
		}
		$data = array();
		$data_ref_func = array();
		$header_data = $this->model_or->get_header($jurnal_id);
		$detil_data = $this->model_or->get_detil($jurnal_id);
		$bilyet_data = $this->model_or->get_bilyet($jurnal_id);

		
		$data['title'] = 'REFUND VOUCHER';		
		$data['jurnal_id'] = $jurnal_id;
		$data['payment'] = 'Refund';
      $references = '';
		$data['ref'] = '';

      //$data['approval'] = $this->get_data_approval('RF');
		$data['approval'] = $this->model_or->get_approval('REFUND');
      
		if($header_data <> 'kosong')
		{
			$data['header'] = $header_data;
		}
		else
		{
			$data['header'] = array();
		}
		if($detil_data <> 'kosong')
		{
			$data['detil'] = $detil_data;
			$data['bilyet'] = $bilyet_data;

         foreach($detil_data as $row => $ref){
            if ($ref->ref_id==='') continue;
            $references .= $ref->ref_id . ", ";
         }
		}
		else
		{
			$data['detil'] = array();
		}


		$data['ref'] = $references; 
		$this->load->view('print_or/or_mall',$data); 
		
	}

  
	private function get_data_ref($ref_id, $ref_line)
	{
		// echo $ref_id;echo '<br/>';
		 $hasil = $this->model_or->get_detil_ref($ref_id, $ref_line); 
		 // echo $hasil;
		 if($hasil != 'kosong')
		 {
			return $hasil;
		 }
		 ELSE
		 {
			return 'kosong'; 
		 }
		 
	}

}

