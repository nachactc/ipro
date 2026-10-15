<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include_once APPPATH.'/third_party/mpdf/mpdf.php';

class M_pdf_a5 {

    public $param;
    public $pdf;

    public function __construct($param = '"L","A5","12","arial",4,4,4,4,0,0')
    {
        $this->param =$param;
        $this->pdf = new mPDF($this->param);
		$this->pdf->SetFont('arial');
		
    }
}