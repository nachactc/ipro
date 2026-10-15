<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tenantverify extends CI_Controller
{

    function __construct()
    {

        parent::__construct();
        // Check login and make sure email has been verified
        check_user_login();

        $this
            ->load
            ->model('model_tenantverify');
        $this
            ->load
            ->library('breadcrumbcomponent');
        $this
            ->load
            ->helper('url');
    }

    function index()
    {
        redirect('tenantverify/tenantverify/applist');
    }

    function globalsearch_list()
    {
        $arcari = array(
            'HEADER.rekanan_name',
            'DETIL.rekananshipping_name', 
        );
        return $arcari;
    }
   
    function initialize_grid()
    {

        $rResult = $this
            ->model_tenantverify
            ->dataapplist();

        $data['rResult'] = $rResult;

        return $data;
    }

    function applist()
    {

        $agreement_id = $this
            ->uri
            ->segment(4);

        $data = array(
            'result' =>'',
            'agreement_id' => ''
        );

        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['unit'] = $this->unit_select();

        $this
            ->breadcrumbcomponent
            ->add('Tenant Verification', 'tenantverify/tenantverify/applist');

        $this
            ->load
            ->view('template/v_header');
        $this
            ->load
            ->view('tenantverify/applist', $data);
        $this
            ->load
            ->view('template/v_footer');
    }

    function cekstatus_ag($rekanan_id,$rekananshipping_line)
    {
        $tsq = "";
        $rsult = $this->model_tenantverify->qrycekstatus_ag($rekanan_id,$rekananshipping_line);
		
		if(COUNT($rsult) <= 0)
		{
			$tsq = "<b><font color='red'> NOT VERIFIED  </b>";
		}
		else
		{
			foreach ($rsult as $aRow)
			{
				$nm = "<b>" . $aRow->strukturunitapprovalauth_name . "</b>";
				if ($aRow->verification == 'VERIFIED')
				{
					$veri = "<b><font color='#00CC00'>" . $aRow->verification . "</font></b>";
				}
				else
				{
					$veri = "<b><font color='red'>" . $aRow->verification . "</font></b>";
				}
				$tsq = $tsq . "" . $nm . " :" . $veri . "&nbsp;&nbsp;&nbsp;&nbsp;";
			}
		}
        
        return $tsq;
		 
    }
    
	function controler_gridlist()
    {
        $vResult = $this->initialize_grid();
        $rResult = $vResult['rResult'];
        //$output=$vResult['output'];
        //$tes="Mulyadi :Done \\nAbu Harris : Not Yet";
        //$tes="Mulyadi :Done , Abu Harris : Not Yet";
		//echo var_dump($rResult);exit;
		//echo count($rResult);exit;
        foreach ($rResult as $aRow)
        {

            $i_link = $aRow['rekanan_id'];
            $i_link2 = $aRow['rekananshipping_line'];
            $rek_name = substr($aRow['rekanan_name'], 0, 25) . '...';
			 
				 $hsl = $this->cekstatus_ag($aRow['rekanan_id'],$aRow['rekananshipping_line']);
			 
           
            $row = array();
            $row[] = $aRow['rekanan_id'];
            $row[] = $aRow['rekanan_id'];
            $row[] = $aRow['rekananshipping_line'];
            //$row[]="<button type='button'  class='btn btn-sm btn-danger' onclick=\"alert('$tes');return false;\" >Detail</button>";
            $row[] = $hsl;
            $row[] = $rek_name;
            $row[] = $aRow['rekananshipping_name']; 
            $row[] = $aRow['debtor'];
            $row[] = $aRow['branch_name']; 
            $row[] = '<a href="/index.php/tenantverify/tenantverify/previewtenant/' . $i_link . '/' . $i_link2 . '" class="btn green  btn-sm"data-toggle="tooltip" title="Print" >View</a>'; 

            if (!empty($row))
            {
                $output['data'][] = $row;
            }
        }

        echo json_encode($output);

    }
	
	public function previewtenant($rekanan_id='',$rekananshipping_line=0)
	{
		if($rekanan_id == '')
		{
			return;
		}
		if($rekananshipping_line == 0)
		{
			return;
		}
		 $rResult = $this
            ->model_tenantverify
            ->dataapplist($rekanan_id,$rekananshipping_line);

        $data['rResult'] = $rResult;
		echo $this->load->view('tenantverify/tenant_preview',$data);
		// echo "<pre/>";
        // echo var_dump($data); 
	}
	
	public function verify_data($rekanan_id='',$rekananshipping_line=0)
	{
		if($rekanan_id == '')
		{
			return;
		}
		if($rekananshipping_line == 0)
		{
			return;
		}
		$hsl = $this->model_tenantverify->verify_action_process($rekanan_id,$rekananshipping_line);
		// echo var_dump($hsl);exit;
		redirect('tenantverify/applist');
	}
	
    function gotosop()
    {
        /*$data['schedule_id']=$this->uri->segment(4);
        $data['button']='PREVIEW';
        $this->load->view('tenantverify/agreement_gotosop', $data);
        */
        $data['schedule_id'] = $this
            ->uri
            ->segment(4);
        $data['button'] = 'PREVIEW';
        $this
            ->load
            ->view('sopverify/agreement_gotosop', $data);
    }
    
	function region_select()
    {
        $this
            ->load
            ->model('template/Master_m');

        $region = $this
            ->Master_m
            ->get_region();
        $options = array(
            '' => '==Pilih=='
        );

        if (count($region))
        {
            foreach ($region as $key => $value)
            {
                $options[$value
                    ->region_id] = $value->region_name;
            }
        }

        return $options;
    }

    function branch_select()
    {
        $this
            ->load
            ->model('template/Master_m');
        $branch = $this
            ->Master_m
            ->get_branch();
        $options = array(
            '' => '==Pilih=='
        );

        if (count($branch))
        {
            foreach ($branch as $key => $value)
            {
                $options[$value
                    ->branch_id] = $value->branch_name;
            }
        }

        return $options;
    }

    function unit_select()
    {
        $this
            ->load
            ->model('template/Master_m');

        $unit = $this
            ->Master_m
            ->get_unit();

        $options = array(
            '' => '==Pilih=='
        );

        if (count($unit))
        {
            foreach ($unit as $key => $value)
            {
                $options[$value
                    ->unit_id] = $value->unit_name;
            }
        }

        return $options;
    }

    function agreement_app()
    {

        if ($_POST)
        {

            $_APP = empty($_POST['postid']) ? '' : $_POST['postid'];
        }

        // Treat input as username
        $type = 'username';

        $username = $this
            ->session
            ->userdata('username');
        $channel_id = $this
            ->session
            ->userdata('channel_id');

        if ($this
            ->model_tenantverify
            ->approveagreement($_APP, $username, $channel_id))
        {

            $result['success'] = true;
            $result['data'] = array(
                'id' => $_APP[0]['id']
            );
            echo json_encode($result);
        }
        else
        {
            $result['success'] = false;
            $result['data'] = array(
                'id' => $_APP[0]['id']
            );
            echo json_encode($result);
        }

    }

    private function _validate_login($username, $password, $type)
    {

        // type is username or email
        $this
            ->load
            ->model("login/mdl_login");
        $this
            ->mdl_login
            ->set_table("master_user");

        $queryUsers = $this
            ->mdl_login
            ->get_where_custom($type, $username);

        foreach ($queryUsers->result() as $row)
        {
            $username = $row->username;
            $user_fullname = $row->user_fullname;
            $user_password = $row->user_password;
            $user_isnew = $row->user_isnew;
            $user_level = $row->user_level;
            $branch_id = $row->branch_id;
        }

        if (md5($password) == $user_password)
        {
            // Successful login
            return true;
        }
        else
        {
            // Invalid password
            return false;
        }
    }

}

