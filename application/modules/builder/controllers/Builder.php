<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Builder extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        $this->load->library('table'); 
        $this->load->library('pagination'); 
        $this->load->model('model_query'); 
		$this->load->library('breadcrumbcomponent');
    } 
	
	function index(){       
        redirect('builder/querylist');
    }
 
	function querylist(){ 
		$data = array();
		$data['result'] = '';
		$data['q_text'] = '';  
		$query = $this->input->post('qbased');
		
		if(!empty($query))
		{ 
			if (strpos(strtolower($query), 'delete') !== false ) {
				echo "<script> alert('Tidak bisa Query Delete, hanya SELECT Saja')</script>";  
				echo "Tidak bisa Query Delete, hanya SELECT Saja";  
			}
			elseif (strpos(strtolower($query), 'update') !== false ) {
				echo "<script>alert('Tidak bisa Query Update, hanya SELECT Saja')</script>"; 
				echo "Tidak bisa Query Update, hanya SELECT Saja"; 
			}
			else {  
				$data['q_text'] =  trim($query);

				$template = array(
						'table_open'            => '<table border="0" id="tbl_me" class="tbl_me table table-striped table-hover compact nowrap" style="width:100%;height: 400px;overflow-y: scroll;display: block;">',

						'thead_open'            => '<thead>',
						'thead_close'           => '</thead>',

						'heading_row_start'     => '<tr>',
						'heading_row_end'       => '</tr>',
						'heading_cell_start'    => '<th>',
						'heading_cell_end'      => '</th>',

						'tbody_open'            => '<tbody>',
						'tbody_close'           => '</tbody>',

						'row_start'             => '<tr>',
						'row_end'               => '</tr>',
						'cell_start'            => '<td>',
						'cell_end'              => '</td>',

						'row_alt_start'         => '<tr>',
						'row_alt_end'           => '</tr>',
						'cell_alt_start'        => '<td>',
						'cell_alt_end'          => '</td>',

						'table_close'           => '</table>'
				);

				$this->table->set_template($template); 
				$q_explode = explode(';',$query);
				 
				if((count($q_explode)-1) <= 1)
				{
					$hasil = $this->model_query->get_data($query);
					$data['result'] = $this->table->generate($hasil);
				}
				else
				{ 
					$data['result']='multiple'; 
				}
			} 
		}
		
		$this->load->view('template/v_header');
		$this->load->view('builder/q_list',$data);
		$this->load->view('template/v_footer');
	}
}  