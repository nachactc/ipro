<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MX_Controller{

    // Configuration properties used in blacklisting
	private $logged_in;

    function __construct(){        
        parent::__construct();  
    	
        // If logged in then set logged_in to TRUE otherwise set to FALSE
		if($this->session->userdata('logged_in'))
		{
			$this->logged_in = TRUE;
		}
		else
		{
			$this->logged_in = FALSE;
        }
    }

    public function index(){
        $data = array();
        // Check if currently timed out
        
        if($this->logged_in === TRUE)
		{
			redirect(base_url() . custom_constants::admin_page_url);
        }
        
        if($this->input->post('username') or $this->input->post('password'))
		{
			$this->load->library("form_validation");

			// Treat input as username
			$type = 'username';
			$this->form_validation->set_rules('username', 'username', 'required');		
			
			$this->form_validation->set_rules('password', 'password', 'required');
			
			if($this->form_validation->run())
			{
				$username = strtolower($this->input->post("username"));
				$password = $this->input->post("password");
				
				if($this->_validate_login($username, $password, $type))
				{
					redirect(custom_constants::admin_page_url);
				
				}
				else
				{
					// If max login attempts reached then reload the login page
					redirect(base_url() . custom_constants::login_page_url);
					// Set data auth_failed to let view know authentication failed
					$data['auth_failed'] = TRUE;
				}
			}
		}
		
		$data['meta_title'] = "Login - eByt [eProperty System]";
		$data['meta_description'] = "Property System, eByt, eProperty Application";
		
		$data['modules'][] = "login";
		$data['methods'][] = "view_login_default";
		
		echo Modules::run("templates/login_template", $data);
    }
		
    private function _validate_login($username, $password, $type) {
		// type is username or email
		$this->load->model("login/mdl_login");
		$this->mdl_login->set_table("master_user");
		
		if($this->mdl_login->count_where($type, $username) > 0)
		{
			$queryUsers = $this->mdl_login->get_where_custom($type, $username);
			foreach($queryUsers->result() as $row)
			{
				$username = $row->username;
				$user_fullname = $row->user_fullname;
				$user_password = $row->user_password;
				$user_isnew = $row->user_isnew;
				$user_level = $row->user_level;
				$branch_id = $row->branch_id;
                $channel_id = $row->user_default_channel_id;
			}

			$this->load->model("login/mdl_login");
			$this->mdl_login->set_table("master_userregion");
			$queryRegion = $this->mdl_login->get_where_custom($type, $username);
			foreach($queryRegion->result() as $row)
			{
				$region_id['region'] = $row->region_id;
			}
			
			if(md5($password) == $user_password)
			{
				$session_data = array(
									'user_isnew' => $user_isnew,
									'username' => $username,
									'user_fullname' =>$user_fullname,
									'logged_in' => TRUE,
									'last_activity' => time(),
									'user_level' => $user_level,
									'branch_id' => $branch_id,
									'logged_in_since' => date('H:i d-m-y'),
                                    'channel_id' => $channel_id
								);

				$this->session->set_userdata($session_data);
				
				// Successful login
				return TRUE;
			}
			else
			{
				// Invalid password
				return FALSE;
			}
		}
		else
		{
			// Invalid username/email
			return FALSE;
		}
    }
	
	public function user_logout() {
		// Destroy the session and redirect the user to the login page
		$this->session->sess_destroy();
		redirect(base_url() . custom_constants::login_page_url);
	}

	function view_login_default() {
		$this->load->view("login/login_default");
	}
}