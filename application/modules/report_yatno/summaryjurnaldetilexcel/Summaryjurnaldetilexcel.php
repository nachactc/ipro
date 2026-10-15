<?php
	
	// If access is requested from anywhere other than index.php then exit
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Summaryjurnaldetilexcel extends MX_Controller{
		
		private $m_parent;
		private $m_child;
		private $m_css;
		private $m_username;
		private $m_userfullname;
		private $m_useremail;
		private $m_regionid;
		private $m_branchid;
		private $m_userlevel;
		
		private $vcelops;
		private $vceldepre;

		private	$headercolor;
		private	$h1color;
		private	$h2color;
		private	$h3color;
		private	$h4color;
		private	$h5color;
		private	$h6color;	
		
		function __construct(){        
			parent::__construct();  
			
			// Check login and make sure email has been verified
			 check_user_login();
			// Load models
			$this->load->library('custom_templates');
			$this->load->library('form_validation');
			// get query strings
			$this->m_parent = $this->uri->segment(2);
			$this->m_child = $this->uri->segment(3);	
			// get user profiles
			 $this->m_username = trim($this->session->userdata['username']);	
			 $this->m_userfullname = trim($this->session->userdata['user_fullname']);	
			 $this->m_useremail = trim($this->session->userdata['user_email']);	
			 $this->m_regionid = trim($this->session->userdata['region_id']);	
			 $this->m_usercompany = trim($this->session->userdata['user_company']);	
			 $this->m_branchid = trim($this->session->userdata['branch_id']);
			 $this->m_userlevel = trim($this->session->userdata['user_level']);

//			$this->m_username = 'harris';//trim($this->session->userdata['username']);	
//			$this->m_userfullname = 'Harris Susanto';//trim($this->session->userdata['user_fullname']);	
//			$this->m_useremail = 'Test@Test.com';//trim($this->session->userdata['user_email']);	
//			$this->m_regionid = 'Test';//trim($this->session->userdata['region_id']);	
//			$this->m_usercompany = 'CT. Corpora';//trim($this->session->userdata['user_company']);	
//			$this->m_branchid = 'Test';//trim($this->session->userdata['branch_id']);
//			$this->m_userlevel = 'Test';//trim($this->session->userdata['user_level']);

			$this->load->library('excel');
			$this->headercolor='909497';
			$this->h1color='a6acaf';
			$this->h2color='bdc3c7';
			$this->h2totalcolor='A2FBE3';
			$this->h3color='d7dbdd';
			$this->h3totalcolor='B5FBA2';
			$this->h4color='d7dbdd';//d7dbdd';	
                        //$this->h4color='e5e7e9';	
			$this->h5color='F2F3F4';	
			$this->h6color='F4F5F6';	
			
			set_time_limit(0);   
			//ini_set('mssql.connect_timeout',0);   
			ini_set('max_execution_time', 3600);   
			ini_set('memory_limit', '2048M' );   
			ini_set("sqlsrv.ClientBufferMaxKBSize","2048288");


			$this->load->database(); // init db connection, already in code
			$this->db->save_queries = false; // ADD THIS LINE TO SOLVE ISSUE
			
		}
		
		public function index(){
			$this->summaryjurnaldetilexcel_list();
			//$this->export();
		}
	
		function summaryjurnaldetilexcel_list(){
			
			//$this->export();
			$data['parent'] = $this->m_parent;
			$data['child'] =  $this->m_child;
			$data['page_title'] = explode ("-", $this->m_child);  
			
			$title = ucwords($this->m_parent) ."-".ucwords(decodeString($this->m_child));
			
			$data['meta_title'] =  custom_constants::meta_title;
			$data['meta_description'] = custom_constants::meta_description1;;
			$data['meta_canonical'] = site_url($this->uri->uri_string());
			$data['meta_stylesheet'] = $this->m_css;
			
			$report =  '';
			//$format =  'GR';
			$startDate =  date("Y-m-d");
			$endDate =  date("Y-m-d");
			$err_message ="";
			
			if($_POST){
				//print_r($_POST);//exit;
				$this->get_report();
				return;
				//$err_message = $this->get_report();
				
				/*
						|   Audit logs functions
						|   DO NOT CHANGE THE PARAMETERS
				*/

				$auditLog['username'] = $this->m_username;
				$auditLog['modules'] = $this->m_child;
				$auditLog['action'] = "LIST ".decodeString($this->m_parent)."-".decodeString($this->m_child);
				$auditLog['description'] = "Commit Transactions";
				$auditLog['log_date'] = date('Y-m-d H:i:s');
				$auditLog['ip_address'] = "IP Address:".$this->input->ip_address();
				$auditLog['last_update']= time();

				auditLog("audit_userslog",$auditLog);
				
			}

			/*
				|   Load modules.
				|   CHANGE ONLY THE PARAMETERS 
			*/		
				
			$data['report'] = $report;
			//$data['format_select'] = $format;				
			$data['startDate_select'] = $startDate;				
			$data['endDate_select'] = $endDate;	
                        
			$data['fillcboregion'] = $this->fillcomboregion();
			$data['fillcbobranch'] = $this->fillcombobranch();
			$data['fillreporttype'] = $this->fillcomboreporttype();
			$data['fillcoa'] = $this->getaccount_select();
			$data['groupcoa'] = $this->fillcombogroupaccount();
                        
			$data['err_message'] = $err_message;
			$data['modules'][] = "summaryjurnaldetilexcel";
			$data['methods'][] = "view_summaryjurnaldetilexcel_list";
			$data['scripts'][] = "view_summaryjurnaldetilexcel_script";
			$data['stylesheet'][] = "view_summaryjurnaldetilexcel_css";
			
			echo Modules::run("templates/admin_template", $data);
			
		}
                
 
		private function get_report(){
			$endDate= $this->input->post('txtPeriodeEnd');
			$branch= $this->input->post('cboBranchName');
			$region= $this->input->post('cboRegionName');
			$reportType= $this->input->post('cboReportType');
			$account= $this->input->post('cboAccountName');
			$report = $this->fillcomboreporttype();
			$reportName = $report[$reportType];
			
			$sql = "select setting_value from master_setting where setting_id='channel_id'";
			$datachannel = $this->db->query($sql)->row_array();
			$channel = $datachannel['setting_value'];
			
			$sql = "select region_name from master_region where region_id='$region'";
			$dataregion = $this->db->query($sql)->row_array();
			$region_name = $dataregion['region_name'];
			$branch_name ="";
			if(!empty($branch)){
				$sql = "select branch_name from master_branch where branch_id='$branch'";
				$databranch = $this->db->query($sql)->row_array();
				$branch_name = $databranch['branch_name'];
				
			}
			$query= $this->q_report($channel,$reportType,$region,$branch,$account,$endDate);
			$num = $query->num_rows();
			$message ="";
			if($num > 0){
				$data['summary'] = $query->result();
				$data['report'] = $reportName;
				$data['endDate'] = $this->getdateformat($endDate);
				$data['branch'] = $branch_name;
				$data['region'] = $region_name;
				
				$this->load->view('ibos/summaryjurnaldetilexcel/summaryjurnaldetilexcel_print', $data);
				
				/*
				switch (substr($reportType, 0, 3)){
					case "JSM":
						$this->report_summaryjurnaldetilexcel($data);
						break;
					case "JSS":
						$this->report_subsummaryjurnaldetilexcel($data);
						break;
					case "JSD":
						$this->report_subsummaryjurnaldetilexcel($data);
						break;
			
				}*/
				
				//$message = "<strong>Sukses Download Data Report, Please Check Download Folder</strong>";
				$message = "Sukses Download Data Report, Please Check Download Folder";
			}else{
				$message = "Data Report is Empty";                        
				//$message = "<strong>Data Report is Empty</strong>";                        
			}
			
			return $message;
		}

		public function get_reportjurnaldetil(){
			$endDate= $this->input->post('txtPeriodeEnd');
			$branch= $this->input->post('cboBranchName');
			$region= $this->input->post('cboRegionName');
			$reportType= $this->input->post('cboReportType');
			$account= $this->input->post('cboAccountName');
			$groupAccount= $this->input->post('cboGroupAccount');
			$report = $this->fillcomboreporttype();
			$reportName = $report[$reportType];
			
			$sql = "select setting_value from master_setting where setting_id='channel_id'";
			$datachannel = $this->db->query($sql)->row_array();
			$channel = $datachannel['setting_value'];
			
			$sql = "select region_name from master_region where region_id='$region'";
			$dataregion = $this->db->query($sql)->row_array();
			$region_name = $dataregion['region_name'];
			$branch_name ="";
			if(!empty($branch)){
				$sql = "select branch_name from master_branch where branch_id='$branch'";
				$databranch = $this->db->query($sql)->row_array();
				$branch_name = $databranch['branch_name'];
				
			}
			$query= $this->q_report($channel,$reportType,$region,$branch,$account,$endDate,$groupAccount);
			$num = $query->num_rows();
			//print_r($query->result_array());die;
			$json= $query->result();
			echo json_encode($json);
		}
		
		private function q_report2($channel,$reportType,$region,$branch,$account,$endDate,$groupAccount){
				$criteria="";    
				$sp="";
				$sql="";
				
				switch ($reportType) {
					
					case "JSDBR":
						$sp = "cp_RptJurnalDetilSummary_SelectByRegion '$channel','$region','$endDate'" ;
						break;
					case "JSDBB":
						$sp = "cp_RptJurnalDetilSummary_SelectByBranch '$channel','$branch','$endDate'" ;
						break;
					case "JSDTR":
						$sp = "EXEC [cp_RptJurnalDetilSummaryYear_SelectByRegion_phantomall] '$channel','$region','$endDate'" ;
						break;
					case "JSDTB":
						$sp = "cp_RptJurnalDetilSummaryYear_SelectByBranch '$channel','$branch','$endDate'" ;
						break;
					
					default:
					  $sp = "cp_RptJurnalDetilSummary_SelectByRegion '$channel','$region','$endDate'" ;
				  }
				$query = $this->db->query($sp);
				
				RETURN $query;
		}
		
		private function q_report($channel,$reportType,$region,$branch,$account,$endDate,$groupAccount){
				$criteria="";    
				$criteria2="";    
				$sp="";
				$sql="";

				
				if(!empty($account)){
					$criteria .=" AND B.acc_id ='$account'";
					$criteria2 .=" AND B.acc_id =''$account''";
				}
				
				if(!empty($groupAccount)){
					$criteria .=" AND B.acc_id in (select acc_id from master_accgroupreport where accgroupreport_name ='$groupAccount')";
					$criteria2 .=" AND B.acc_id in (select acc_id from master_accgroupreport where accgroupreport_name =''$groupAccount'')";
				}
				
				switch ($reportType) {
					
					case "JSMBR":
					  $sp = "cp_RptJurnalsummary_SelectByRegion '$channel','$region','$endDate'" ;
					  break;
					case "JSMBBR":
					  $sp = "cp_RptJurnalsummary_SelectByRegion_bybranch '$channel','$region','$endDate'" ;
					  break;
					case "JSMBB":
					  $sp = "cp_RptJurnalSummary_SelectByBranch '$channel','$branch','$endDate'" ;
					  break;
					case "JSMTR":
					  $sp = "cp_RptJurnalSummaryYear_SelectByRegion '$channel','$region','$endDate'" ;
					  break;
					case "JSMTB":
					  $sp = "cp_RptJurnalSummaryYear_SelectByBranch '$channel','$branch','$endDate'" ;
					  break;
				  
					case "JSSBR":
					  $sp = "cp_RptJurnalSubSummary_SelectByRegion '$channel','$region','$endDate'" ;
					  break;
					case "JSSBB":
					  $sp = "cp_RptJurnalSubSummary_SelectByBranch '$channel','$branch','$endDate'" ;
					  break;
					case "JSSTR":
					  $sp = "cp_RptJurnalSubSummaryYear_SelectByRegion '$channel','$region','$endDate'" ;
					  break;
					case "JSSTB":
					  $sp = "cp_RptJurnalSubSummaryYear_SelectByBranch '$channel','$branch','$endDate'" ;
					  break;

					case "JSDBR":
						$sp = "cp_RptJurnalDetilSummary_SelectByRegion '$channel','$region','$endDate'" ;
						break;
					case "JSDBB":
						$sp = "cp_RptJurnalDetilSummary_SelectByBranch '$channel','$branch','$endDate'" ;
						break;
					//case "JSDTR":
					//	$sp = "cp_RptJurnalDetilSummaryYear_SelectByRegion '$channel','$region','$endDate'" ;
					//	break;
					case "JSDTR":
						$sp = "cp_RptJurnalDetilSummaryYear_SelectByRegion_phantomall '$channel','$region','$endDate', '$criteria2'" ;
						break;
					case "JSDTB":
						$sp = "cp_RptJurnalDetilSummaryYear_SelectByBranch '$channel','$branch','$endDate'" ;
						break;
					
					default:
					  $sp = "cp_RptJurnalDetilSummary_SelectByRegion '$channel','$region','$endDate'" ;
				}
				
				if($reportType==='JSDTR'){
					$sql = "SET NOCOUNT ON;
							CREATE TABLE #TMP_NUMSUMMARYDETIL
							(
								id	varchar(50) NULL,
								num	int NULL
							)

							INSERT INTO #TMP_NUMSUMMARYDETIL
							EXECUTE $sp ";
					
				}else{
					switch (substr($reportType, 0, 3)){
						case "JSM":
							$sql = "
								SET NOCOUNT ON;

								CREATE TABLE #TMP_SUMMARY
								(
									channel_id	varchar(10) NULL,
									region_id	varchar(10) NULL,
									branch_id	varchar(10) NULL,
									periode_id	varchar(10) NULL,
									acc_id          varchar(7) NULL,
									acc_name	varchar(150) NULL,
									acc_path	varchar(50) NULL,
									jurnalsaldoawal_idr	decimal(18,2) NULL,
									jurnalsaldodebet_idr	decimal(18,2) NULL,
									jurnalsaldokredit_idr	decimal(18,2) NULL,
									jurnalsaldomutasi_idr	decimal(18,2) NULL,
									jurnalsaldoakhir_idr    decimal(18,2) NULL
								)

								INSERT INTO #TMP_SUMMARY
								EXECUTE $sp ";
							break;
						case "JSS":
							$sql = "
								SET NOCOUNT ON;

								CREATE TABLE #TMP_SUBSUMMARY
								(
									channel_id	varchar(10) NULL,
									periode_id	varchar(10) NULL,
									acc_id          varchar(7) NULL,
									acc_name	varchar(150) NULL,
									acc_path	varchar(50) NULL,
									rekanan_id      varchar(10) NULL,
									rekanan_name	varchar(100) NULL,
									jurnalsaldoawal_idr	decimal(18,2) NULL,
									jurnalsaldodebet_idr	decimal(18,2) NULL,
									jurnalsaldokredit_idr	decimal(18,2) NULL,
									jurnalsaldomutasi_idr	decimal(18,2) NULL,
									jurnalsaldoakhir_idr    decimal(18,2) NULL
								)

								INSERT INTO #TMP_SUBSUMMARY
								EXECUTE $sp ";
							break;
						case "JSD":
							$sql = "
								SET NOCOUNT ON;

								CREATE TABLE #TMP_SUMMARYDETIL
								(
									channel_id	varchar(10) NULL,
									periode_id	varchar(10) NULL,
									acc_id          varchar(7) NULL,
									acc_name	varchar(150) NULL,
									jurnal_id	varchar(100) NULL,
									jurnal_descr	varchar(350) NULL,
									jurnal_bookdate	smalldatetime NULL,
									jurnal_source	varchar(50) NULL,
									rekanan_name	varchar(150) NULL,
									region_name	varchar(150) NULL,
									branch_name	varchar(150) NULL,
									strukturunit_name       varchar(150) NULL,
									jurnalsaldoawal_idr	decimal(18,2) NULL,
									jurnalsaldodebet_idr	decimal(18,2) NULL,
									jurnalsaldokredit_idr	decimal(18,2) NULL,
									jurnalsaldomutasi_idr	decimal(18,2) NULL,
									jurnalsaldoakhir_idr    decimal(18,2) NULL
								)

								INSERT INTO #TMP_SUMMARYDETIL
								EXECUTE $sp ";
							break;
					}
				}
				$this->db->query($sql);

				if($reportType==='JSDTR'){
					$sql = "SELECT * FROM #TMP_NUMSUMMARYDETIL";
					
				}else{
					switch (substr($reportType, 0, 3)){
						case "JSM":
							$sql ="SELECT * FROM #TMP_SUMMARY B WHERE 1=1 $criteria ";
							break;
						case "JSS":
							$sql ="SELECT * FROM #TMP_SUBSUMMARY B WHERE 1=1 $criteria ORDER BY acc_id, rekanan_name";
							break;
						case "JSD":
							$sql ="SELECT * FROM #TMP_SUMMARYDETIL B WHERE 1=1 $criteria ORDER BY acc_id, jurnal_bookdate,jurnal_id";
							break;
					}
				}
				
				/*
				if(empty($criteria)){
					switch (substr($reportType, 0, 3)){
						case "JSM":
							$sql ="SELECT * FROM #TMP_SUMMARY";
							break;
						case "JSS":
							$sql ="SELECT * FROM #TMP_SUBSUMMARY ORDER BY acc_id, rekanan_name";
							break;
						case "JSD":
							$sql ="SELECT * FROM #TMP_SUMMARYDETIL ORDER BY acc_id, jurnal_bookdate,jurnal_id";
							break;
					}
					
				}else{
					switch (substr($reportType, 0, 3)){
						case "JSM":
							$sql ="SELECT * FROM #TMP_SUMMARY WHERE 1=1 $criteria ";
							break;
						case "JSS":
							$sql ="SELECT * FROM #TMP_SUBSUMMARY WHERE 1=1 $criteria ORDER BY acc_id, rekanan_name";
							break;
						case "JSD":
							$sql ="SELECT * FROM #TMP_SUMMARYDETIL WHERE 1=1 $criteria ORDER BY acc_id, jurnal_bookdate,jurnal_id";
							break;
					}
					
				}*/

				$query = $this->db->query($sql) ;
				//print_r($query->result_array());die;
				
				if($reportType==='JSDTR'){
					$sql = "DROP TABLE #TMP_NUMSUMMARYDETIL";
					
				}else{
					switch (substr($reportType, 0, 3)){
						case "JSM":
							$sql="DROP TABLE #TMP_SUMMARY ";
							break;
						
						case "JSS":
							$sql="DROP TABLE #TMP_SUBSUMMARY ";
							break;
						
						case "JSD":
							$sql="DROP TABLE #TMP_SUMMARYDETIL ";
							break;
					}
				}
				
				$this->db->query($sql);
				//print_r($query->result_array());exit;
				return $query;
		}
						
		public function generate_datareport(){
			$endDate= $this->input->post('txtPeriodeEnd');
			$branch= $this->input->post('cboBranchName');
			$region= $this->input->post('cboRegionName');
			$reportType= $this->input->post('cboReportType');
			$account= $this->input->post('cboAccountName');
			$groupAccount= $this->input->post('cboGroupAccount');
			$report = $this->fillcomboreporttype();
			$reportName = $report[$reportType];
			
			$sql = "select setting_value from master_setting where setting_id='channel_id'";
			$datachannel = $this->db->query($sql)->row_array();
			$channel = $datachannel['setting_value'];

			$query= $this->q_report($channel,$reportType,$region,$branch,$account,$endDate,$groupAccount);
			$json= $query->result();
			//print_r($json);
			echo json_encode($json);
		}
			
		public function load_datareport(){
			
			$id= $this->input->post('id');
			
			$PageNumber= $this->input->post('PageNumber');
			$RowsOfPage= $this->input->post('RowsOfPage');
			$id = $id?$id:'BCA9EF8E-6787-4DFC-AF6A-5FB73E2A4130';
			$PageNumber = $PageNumber?$PageNumber:1;
			$RowsOfPage = $RowsOfPage?$RowsOfPage:100000;
			
			$sql= "EXEC [cp_RptJurnalDetilSummaryYear_SelectPage_phantom] '$id',$PageNumber,$RowsOfPage";
			$query = $this->db->query($sql);
			$json= $query->result();
			//print_r($json);
			//die;
			
			echo json_encode($json);
			//print_r($json);die;
			//return $json;
		}
		
		 public function delete_datareport(){
			$id= $this->input->post('id');
			
			$this->db->trans_begin();
		
			$sql= "DELETE FROM TMP_SUMMARYDETIL WHERE idreport= '$id'";
			$this->db->query($sql);
			
			if ($this->db->trans_status() === FALSE)
			{	
				$this->db->trans_rollback();
				echo "0";
			}else{
				$this->db->trans_commit();
				echo "1";
			}
		}
                
                private function report_summaryjurnaldetilexcel($data){
                    	
                        $summary = $data['summary'];        
                        $styleArray = array(
                            'borders' => array(
                                'allborders' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_THICK
                                )
                            )
                        );

                        //Set Sheet Title
                        $this->excel->setActiveSheetIndex(0);
						$this->excel->getActiveSheet()->setTitle('Summary Jurnal Detil');
                        
									//Set Width Column
						$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
						$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
						$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
						$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
						$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
						$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
						$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
						$this->excel->getActiveSheet()->getRowDimension('4')->setRowHeight(20);
						
									/// Title Configuration
						$this->cellFormatTitle('A1', $data['report'] );
                        if(!empty($data['region'])){
                            $this->cellFormatSubtitle('A2', 'Region '. $data['region'] ); //.$this->getdateformat($data['datePeriode']));
                        }else{
                            $this->cellFormatSubtitle('A2', 'Branch '. $data['branch'] ); //.$this->getdateformat($data['datePeriode']));
                        }
                        $this->cellFormatSubtitle('A3', 'Per ' . $data['endDate'] );  //.$this->getdateformat($data['datePeriode']));
			
						$this->cellFormatHDesc('A4', 'Account');
						$this->cellFormatHDesc('B4', 'Description');
						$this->cellFormatHDesc('C4', 'Saldo Awal');
						$this->cellFormatHDesc('D4', 'Debet');
						$this->cellFormatHDesc('E4', 'Kredit');
						$this->cellFormatHDesc('F4', 'Mutasi');
						$this->cellFormatHDesc('G4', 'Saldo Akhir');
									
                        $rownumber = 4;
                        //$rownum = 4;
						$i = 0;

                        $saldoawal_sum= 0;
						$debet_sum= 0;
						$kredit_sum= 0;
						$mutasi_sum= 0;
						$saldoakhir_sum= 0;

                        $saldoawal= 0;
						$debet= 0;
						$kredit= 0;
						$mutasi= 0;
						$saldoakhir= 0;
                        
						foreach ($summary as $row){
										
							$acc_id = $row->acc_id;
							$acc_name = $row->acc_name;
											$saldoawal = $row->jurnalsaldoawal_idr;
											$debet = $row->jurnalsaldodebet_idr;
											$kredit = -1 * ($row->jurnalsaldokredit_idr);
											$mutasi = $row->jurnalsaldomutasi_idr;
											$saldoakhir= $row->jurnalsaldoakhir_idr;
											
											$i += 1;
															
											$this->cellFormatH6('A' . strval($i +$rownumber ),$acc_id);
											$this->cellFormatH6('B' . strval($i +$rownumber ),$acc_name);
											$this->cellFormatH6Num('C' . strval($i +$rownumber ),$saldoawal);
											$this->cellFormatH6Num('D' . strval($i +$rownumber ),$debet);
											$this->cellFormatH6Num('E' . strval($i +$rownumber ),$kredit);
											$this->cellFormatH6Num('F' . strval($i +$rownumber ),$mutasi);
											$this->cellFormatH6Num('G' . strval($i +$rownumber ),$saldoakhir);

											$saldoawal_sum += $saldoawal;
											$debet_sum += $debet;
											$kredit_sum += $kredit;
											$mutasi_sum += $mutasi;
											$saldoakhir_sum += $saldoakhir;

						}
                        $i += 1;
                        
                        $this->excel->getActiveSheet()->mergeCells('A' . strval($i +$rownumber ).':B'. strval($i +$rownumber ));
                        $this->cellFormatH4DescAmount('A' . strval($i +$rownumber ),'TOTAL');
                        //$this->cellFormatH6('B' . strval($i +$rownumber ),$acc_name);
                        $this->cellFormatH4Amount('C' . strval($i +$rownumber ),$saldoawal_sum);
                        $this->cellFormatH4Amount('D' . strval($i +$rownumber ),$debet_sum);
                        $this->cellFormatH4Amount('E' . strval($i +$rownumber ),$kredit_sum);
                        $this->cellFormatH4Amount('F' . strval($i +$rownumber ),$mutasi_sum);
                        $this->cellFormatH4Amount('G' . strval($i +$rownumber ),$saldoakhir_sum);


						$filename='REPORT ' .$data['report'] . '.xls'; //save our workbook as this file name
						header('Content-Type: application/vnd.ms-excel'); //mime type
			//			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //mime type
						header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
						header('Cache-Control: max-age=0'); //no cache
						
						//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
						//if you want to save it as .XLSX Excel 2007 format
						$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
						//force user to download the Excel file without writing it to server's HD
						ob_end_clean();
						$objWriter->save('php://output'); 
                    
                }
		
                private function report_subsummaryjurnaldetilexcel($data){
                    	
                        $summary = $data['summary'];        
                        $styleArray = array(
                            'borders' => array(
                                'allborders' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_THICK
                                )
                            )
                        );

                        //Set Sheet Title
                        $this->excel->setActiveSheetIndex(0);
						$this->excel->getActiveSheet()->setTitle('Jurnal Sub Summary');
									
									//Set Width Column
						$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
						$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
						$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
						$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
						$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
						$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
						$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
						$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
						$this->excel->getActiveSheet()->getRowDimension('4')->setRowHeight(20);
			
                        /// Title Configuration
						$this->cellFormatTitle('A1', $data['report'] );
                        if(!empty($data['region'])){
                            $this->cellFormatSubtitle('A2', 'Region '. $data['region'] ); //.$this->getdateformat($data['datePeriode']));
                        }else{
                            $this->cellFormatSubtitle('A2', 'Branch '. $data['branch'] ); //.$this->getdateformat($data['datePeriode']));
                        }
                        $this->cellFormatSubtitle('A3', 'Per ' . $data['endDate'] );  //.$this->getdateformat($data['datePeriode']));
			
						$this->cellFormatHDesc('A4', 'Account');
                        $this->excel->getActiveSheet()->mergeCells('B4:C4');
						$this->cellFormatHDesc('B4', 'Description');
						$this->cellFormatHDesc('D4', 'Saldo Awal');
						$this->cellFormatHDesc('E4', 'Debet');
						$this->cellFormatHDesc('F4', 'Kredit');
						$this->cellFormatHDesc('G4', 'Mutasi');
						$this->cellFormatHDesc('H4', 'Saldo Akhir');
                        
                        $rownumber = 4;
                        //$rownum = 4;
						$i = 0;
						$account_current= "";
                        
                        $saldoawal_sumall= 0;
						$debet_sumall= 0;
						$kredit_sumall= 0;
						$mutasi_sumall= 0;
						$saldoakhir_sumall= 0;

                        $saldoawal_sum= 0;
						$debet_sum= 0;
						$kredit_sum= 0;
						$mutasi_sum= 0;
						$saldoakhir_sum= 0;

                        $saldoawal= 0;
						$debet= 0;
						$kredit= 0;
						$mutasi= 0;
						$saldoakhir= 0;
									
						foreach ($summary as $row){
										
							$acc_id = $row->acc_id;
							$acc_name = $row->acc_name;
							$rekanan_id = $row->rekanan_id;
							$rekanan_name = $row->rekanan_name;
							$saldoawal = $row->jurnalsaldoawal_idr;
							$debet = $row->jurnalsaldodebet_idr;
							$kredit = -1 * ($row->jurnalsaldokredit_idr);
							$mutasi = $row->jurnalsaldomutasi_idr;
							$saldoakhir= $row->jurnalsaldoakhir_idr;
							
							if ($account_current != $acc_id && $acc_id != '' ){   ///account
									if ($account_current != ''){
										$i +=1;
									}
							
							
									$this->cellFillValueByCode("D", $i + $rownumber, "coa", $saldoawal_sum);
									$this->cellFillValueByCode("E", $i + $rownumber, "coa", $debet_sum);
									$this->cellFillValueByCode("F", $i + $rownumber, "coa", $kredit_sum);
									$this->cellFillValueByCode("G", $i + $rownumber, "coa", $mutasi_sum);
									$this->cellFillValueByCode("H", $i + $rownumber, "coa", $saldoakhir_sum);
									
									$saldoawal_sum= 0;
									$debet_sum= 0;
									$kredit_sum= 0;
									$mutasi_sum= 0;
									$saldoakhir_sum= 0;
									
									$i += 1;
									$this->cellFormatH3DescAmount('A' . strval($i + $rownumber ),$acc_id );
									$this->cellFormatH3DescAmount('B' . strval($i + $rownumber ),$acc_name );
									$this->cellFormatH3AmountColor('C' . strval($i + $rownumber ));
									$this->cellFormatH3Amount('D' . strval($i + $rownumber ),'coa');
									$this->cellFormatH3Amount('E' . strval($i + $rownumber ),'coa');
									$this->cellFormatH3Amount('F' . strval($i + $rownumber ),'coa');
									$this->cellFormatH3Amount('G' . strval($i + $rownumber ),'coa');
									$this->cellFormatH3Amount('H' . strval($i + $rownumber ),'coa');
									
									if(!empty($rekanan_name) || $saldoawal <> 0 || $debet <> 0 || $kredit <> 0 || $mutasi <> 0 || $saldoakhir <> 0 ){
										$i += 1;
										$this->cellFormatH6('C' . strval($i + $rownumber ),$rekanan_name);
										$this->cellFormatH6Num('D' . strval($i + $rownumber ),$saldoawal);
										$this->cellFormatH6Num('E' . strval($i + $rownumber ),$debet);
										$this->cellFormatH6Num('F' . strval($i + $rownumber ),$kredit);
										$this->cellFormatH6Num('G' . strval($i + $rownumber ),$mutasi);
										$this->cellFormatH6Num('H' . strval($i + $rownumber ),$saldoakhir);                                        
									}
							}else{
									if(!empty($rekanan_name) || $saldoawal <> 0 || $debet <> 0 || $kredit <> 0 || $mutasi <> 0 || $saldoakhir <> 0){
										$i += 1;
										$this->cellFormatH6('C' . strval($i + $rownumber ),$rekanan_name);
										$this->cellFormatH6Num('D' . strval($i + $rownumber ),$saldoawal);
										$this->cellFormatH6Num('E' . strval($i + $rownumber ),$debet);
										$this->cellFormatH6Num('F' . strval($i + $rownumber ),$kredit);
										$this->cellFormatH6Num('G' . strval($i + $rownumber ),$mutasi);
										$this->cellFormatH6Num('H' . strval($i + $rownumber ),$saldoakhir);                                        
									}
							}
											
							$account_current=$acc_id;
							
							$saldoawal_sum += $saldoawal;
							$debet_sum += $debet;
							$kredit_sum += $kredit;
							$mutasi_sum += $mutasi;
							$saldoakhir_sum += $saldoakhir;
							
							$saldoawal_sumall += $saldoawal;
							$debet_sumall += $debet;
							$kredit_sumall += $kredit;
							$mutasi_sumall += $mutasi;
							$saldoakhir_sumall += $saldoakhir;

						}
									
									
						$this->cellFillValueByCode("D", $i + $rownumber, "coa", $saldoawal_sum);
						$this->cellFillValueByCode("E", $i + $rownumber, "coa", $debet_sum);
						$this->cellFillValueByCode("F", $i + $rownumber, "coa", $kredit_sum);
						$this->cellFillValueByCode("G", $i + $rownumber, "coa", $mutasi_sum);
						$this->cellFillValueByCode("H", $i + $rownumber, "coa", $saldoakhir_sum);
						
						$i += 2;
						$this->excel->getActiveSheet()->mergeCells('A' . strval($i +$rownumber ).':C'. strval($i +$rownumber ));
						$this->cellFormatH2DescAmount('A' . strval($i +$rownumber ),'TOTAL');
						//$this->cellFormatH6('B' . strval($i +$rownumber ),$acc_name);
						$this->cellFormatH2Amount('D' . strval($i +$rownumber ),$saldoawal_sumall);
						$this->cellFormatH2Amount('E' . strval($i +$rownumber ),$debet_sumall);
						$this->cellFormatH2Amount('F' . strval($i +$rownumber ),$kredit_sumall);
						$this->cellFormatH2Amount('G' . strval($i +$rownumber ),$mutasi_sumall);
						$this->cellFormatH2Amount('H' . strval($i +$rownumber ),$saldoakhir_sumall);


						$filename='REPORT ' .$data['report'] . '.xls'; //save our workbook as this file name
						header('Content-Type: application/vnd.ms-excel'); //mime type
			//			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //mime type
						header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
						header('Cache-Control: max-age=0'); //no cache
						
						//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
						//if you want to save it as .XLSX Excel 2007 format
						$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
						//force user to download the Excel file without writing it to server's HD
						ob_end_clean();
						$objWriter->save('php://output'); 
                    
                }
		
                private function getperiodeyear(){
					
					$this->load->model("ibos/transbrowser/mdl_transbrowser");
					
					$options = "";
					$sq="select distinct year(periode_datestart) as tahun from master_periode
					order by tahun asc";
					$response = $this->mdl_transbrowser->_custom_query($sq)->result();
					
					$options[""]= "-- Please select --";
					foreach($response as $row)
					{
						$options[$row->tahun]= $row->tahun;
					}
					
					return $options;
				}
                
				private function cellGetValue($cells){
							$val = $this->excel->getActiveSheet()->getCell($cells)->getValue();
							return $val;
				}

				private function cellFillValueByCode($cell_code,$cell_num,$code,$fill){
                        while ($cell_num > 0) {
                            if($this->cellGetValue($cell_code.strval($cell_num)) === $code){
                                $this->cellValue($cell_code.strval($cell_num), $fill);
                                break;
                            }
                            $cell_num--;
                        }
                }

		private function cellColor($cells,$color){
			$this->excel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'startcolor' => array(
			'rgb' => $color
			)
			));
		}
		
		private function cellFontFormat($cells,$size, $bold){
			$this->excel->getActiveSheet()->getStyle($cells)->getFont()->setSize($size);
			if($bold){
				$this->excel->getActiveSheet()->getStyle($cells)->getFont()->setBold(true);
			}
		}
		
		private function cellValue($cells,$value){
			$this->excel->getActiveSheet()->setCellValue($cells, $value );
		}		
		
		private function cellNumberFormat($cells){
			$this->excel->getActiveSheet()->getStyle($cells)->getNumberFormat()->setFormatCode('#,##0.00');
		}		
		
		private function cellWrap($cells){
			$this->excel->getActiveSheet()->getStyle($cells)->getAlignment()->setWrapText(true);
		}		
		
		private function cellAlignment($cells,$value){
			switch ($value) {
			  case 'center':
				$this->excel->getActiveSheet()->getStyle($cells)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				break;
			  case 'right':
				$this->excel->getActiveSheet()->getStyle($cells)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				break;
			  default:
				$this->excel->getActiveSheet()->getStyle($cells)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				break;
			}			
		}
		private function cellVAlignment($cells,$value){
			switch ($value) {
			  case 'center':
				$this->excel->getActiveSheet()->getStyle($cells)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				break;
			  case 'top':
				$this->excel->getActiveSheet()->getStyle($cells)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				break;
			  default:
				$this->excel->getActiveSheet()->getStyle($cells)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
				break;
			}			
		}
		
		private function cellFormatTitle($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,14,true);
                        $this->cellAlignment($cells, 'left');
		}			
		
		private function cellFormatSubtitle($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,12,true);
		}		
		
		private function cellFormatH($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,12,true);
			$this->cellColor($cells,$this->headercolor);
		}		
		
		private function cellFormatHDesc($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,12,true);
			$this->cellColor($cells,$this->headercolor);
			$this->cellAlignment($cells, 'center');
			$this->cellVAlignment($cells, 'center');
		}
		
		private function cellFormatHDescL($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,12,true);
			$this->cellColor($cells,$this->headercolor);
			$this->cellAlignment($cells, 'left');
			$this->cellVAlignment($cells, 'center');
		}
		
		private function cellFormatHDescAmount($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,12,true);
			$this->cellColor($cells, $this->headercolor);
		}			
		
		private function cellFormatHAmount($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,12,true);
			$this->cellColor($cells,$this->headercolor);
			$this->cellAlignment($cells,'right');
			$this->cellNumberFormat($cells);
		}		

		private function cellFormatH1($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,12,false);
		}
		
		private function cellFormatH1DescAmount($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,12,true);
			// $this->cellColor($cells,$this->h1color);
		}			
		
		private function cellFormatH1Amount($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,12,true);
			$this->cellColor($cells,$this->h1color);
			$this->cellAlignment($cells,'right');
			$this->cellNumberFormat($cells);
		}		
		
		private function cellFormatH2($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,11.5,false);
		}
		
		private function cellFormatH2DescAmount($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,11.5,true);
			$this->cellColor($cells,$this->h2totalcolor);
		}			
		
		private function cellFormatH2Amount($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,11.5,true);
			$this->cellColor($cells,$this->h2totalcolor);
			$this->cellAlignment($cells,'right');
			$this->cellNumberFormat($cells);
		}		
		private function cellFormatH2AmountColor($cells){
			$this->cellColor($cells,$this->h3color);
		}			
		
		private function cellFormatH3($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,11,false);
		}
		
		private function cellFormatH3Num($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,11,false);
			$this->cellAlignment($cells,'right');
			$this->cellNumberFormat($cells);
		}
		
		private function cellFormatH3DescAmount($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,11,true);
			$this->cellColor($cells,$this->h3color);
                        $this->cellAlignment($cells,'left');
		}			
		private function cellFormatH3DescTotalAmount($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,11,true);
			$this->cellColor($cells,$this->h3totalcolor);
                        $this->cellAlignment($cells,'right');
		}			
		private function cellFormatH3AmountColor($cells){
			$this->cellColor($cells,$this->h3color);
		}			
		
		private function cellFormatH3Amount($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,11,true);
			$this->cellColor($cells,$this->h3color);
			$this->cellAlignment($cells,'right');
			$this->cellNumberFormat($cells);
		}		
		private function cellFormatH3TotalAmount($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,11,true);
			$this->cellColor($cells,$this->h3totalcolor);
			$this->cellAlignment($cells,'right');
			$this->cellNumberFormat($cells);
		}		
		
		private function cellFormatH4($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,10.5,false);
		}
		
		private function cellFormatH4Num($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,10.5,false);
			$this->cellAlignment($cells,'right');
			$this->cellNumberFormat($cells);
		}
                
		private function cellFormatH4AmountColor($cells){
			$this->cellColor($cells,$this->h4color);
		}			
		
		private function cellFormatH4DescAmount($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,10.5,true);
			$this->cellColor($cells,$this->h4color);
		}			
		
		private function cellFormatH4Amount($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,10.5,true);
			$this->cellColor($cells,$this->h4color);
			$this->cellAlignment($cells,'right');
			$this->cellNumberFormat($cells);
		}		
		
		private function cellFormatH5($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,10,false);
		}
		
		private function cellFormatH5Num($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,10,false);
			$this->cellAlignment($cells,'right');
			$this->cellNumberFormat($cells);
		}
		
		private function cellFormatH5DescAmount($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,10,true);
			// $this->cellColor($this->h5color);
		}			
		
		private function cellFormatH5Amount($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,10,true);
			$this->cellColor($cells,$this->h5color);
			$this->cellAlignment($cells,'right');
			$this->cellNumberFormat($cells);
		}				
		
		private function cellFormatH6($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,10,false);
			$this->cellAlignment($cells,'left');
                        //$this->cellColor($cells,$this->h4color);
		}
		private function cellFormatH6Wrap($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,10,false);
			$this->cellAlignment($cells,'left');
                        $this->cellColor($cells,$this->h4color);
                        $this->cellWrap($cells);
		}
		private function cellFormatH6sec($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,10,false);
			$this->cellAlignment($cells,'left');
                        $this->cellColor($cells,$this->h6color);
		}
		private function cellFormatH6secWrap($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,10,false);
			$this->cellAlignment($cells,'left');
                        $this->cellColor($cells,$this->h4color);
                        $this->cellWrap($cells);
		}		
		private function cellFormatH6Num($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,10,false);
			$this->cellAlignment($cells,'right');
			$this->cellNumberFormat($cells);
                        //$this->cellColor($cells,$this->h4color);
		}
		private function cellFormatH6NumSec($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,10,false);
			$this->cellAlignment($cells,'right');
			$this->cellNumberFormat($cells);
                        $this->cellColor($cells,$this->h6color);
                        
		}
		
		private function cellFormatH6DescAmount($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,10,true);
                        $this->cellAlignment($cells,'center');
			// $this->cellColor($cells,$this->h6color);
		}			
		
		private function cellFormatH6Amount($cells,$value){
			$this->cellValue($cells,$value);
			$this->cellFontFormat($cells,10,true);
			$this->cellColor($cells,$this->h6color);
			$this->cellAlignment($cells,'right');
			$this->cellNumberFormat($cells);
		}		
		/*
			|
			| function load views
			|
		*/	
		function view_summaryjurnaldetilexcel_list() {
			$this->load->view("ibos/summaryjurnaldetilexcel/summaryjurnaldetilexcel_list");
		}
		
		function view_summaryjurnaldetilexcel_script(){
			$this->load->view("ibos/summaryjurnaldetilexcel/summaryjurnaldetilexcel_script");
		}
		
		function view_summaryjurnaldetilexcel_form(){
			$this->load->view("ibos/summaryjurnaldetilexcel/summaryjurnaldetilexcel_form");
		}
		
		function view_summaryjurnaldetilexcel_css(){
			$this->load->view("ibos/summaryjurnaldetilexcel/summaryjurnaldetilexcel_css");
		}
		
		private function getdateformat($date){
			$year= substr($date,0,4);
			$month= substr($date,5,2);
			$day= substr($date,8,2);
			
			return $day . '-' . $month . '-' . $year;
		}

		private function format_type()
		{       
			$options    = array('GA' => 'Group by Account');
			$options    += array('GR' => 'Group by Rekanan');
						
			return $options;
		}
		private function report_type()
		{       
			$options    = array('SUMMARY PO CONSOLE' => 'SUMMARY PO CONSOLE');
			//$options    += array('AGING AR' => 'AGING AR');
						
			return $options;
		}
		private function coverage_type()
		{       
			$options    = array('REGION' => 'Region');
			$options    += array('REGIONBRANCH' => 'Region and Branch');
						
			return $options;
		}

                function fillcomboregion() {

                    $this->load->model("ibos/transbrowser/mdl_transbrowser");
                    $sql = "select region_id,region_name from master_region";
                    $hdata = $this->mdl_transbrowser->_custom_query($sql)->result();

                    $options    = array('' => '-- Pilih --');   

                    if (count($hdata)) {
                        foreach ($hdata as $key => $value) {
                            $options[$value->region_id] = $value->region_name;
                        }
                    }

                    return $options;
                }
                
                function fillcombobranch() {

                    $this->load->model("ibos/transbrowser/mdl_transbrowser");
                    $sql = "select branch_id,branch_name from master_branch";
                    $hdata = $this->mdl_transbrowser->_custom_query($sql)->result();

                    $options    = array('' => '-- Pilih --');   

                    if (count($hdata)) {
                        foreach ($hdata as $key => $value) {
                            $options[$value->branch_id] = $value->branch_name;
                        }
                    }

                    return $options;
                }

                function fillcomboitemtype() {

                    $this->load->model("ibos/transbrowser/mdl_transbrowser");
                    $sql = "select iteminventorytype_id,iteminventorytype_name from master_iteminventorytype";
                    $hdata = $this->mdl_transbrowser->_custom_query($sql)->result();

                    //$options    = array('' => '-- Pilih --');   

                    if (count($hdata)) {
                        foreach ($hdata as $key => $value) {
                            $options[$value->iteminventorytype_id] = $value->iteminventorytype_id . '-' . $value->iteminventorytype_name;
                        }
                    }

                    return $options;
                }
                function fillcomboreporttype() {

                    $options    = array('' => '-- Pilih --');   
                    $options    += array('JSMBR' => 'Jurnal Summary Bulanan by Region');
                    //$options    += array('JSBBR' => 'Jurnal Summary Bulanan Branch by Region');
                    $options    += array('JSMBB' => 'Jurnal Summary Bulanan by Branch');
                    $options    += array('JSMTR' => 'Jurnal Summary Tahunan by Region');
                    $options    += array('JSMTB' => 'Jurnal Summary Tahunan by Branch');
                    $options    += array('JSSBR' => 'Jurnal Sub Summary Bulanan by Region');
                    $options    += array('JSSBB' => 'Jurnal Sub Summary Bulanan by Branch');
                    $options    += array('JSSTR' => 'Jurnal Sub Summary Tahunan by Region');
                    $options    += array('JSSTB' => 'Jurnal Sub Summary Tahunan by Branch');
                    $options    += array('JSDBR' => 'Jurnal Detil Summary Bulanan by Region');
                    $options    += array('JSDBB' => 'Jurnal Detil Summary Bulanan by Branch');
                    $options    += array('JSDTR' => 'Jurnal Detil Summary Tahunan by Region');
                    $options    += array('JSDTB' => 'Jurnal Detil Summary Tahunan by Branch');
                    //$options    += array('JDTBR' => 'Jurnal Detil Bulanan by Region');
                    //$options    += array('JDTBB' => 'Jurnal Detil Bulanan by Branch');
                    
                    return $options;
                }

                public function getrekanan_select2(){
			$criteria = empty($_GET['q']) ? ' ' : $_GET['q'];

			// Hardcoded exclude Used Items Solutions base on needs.
			$sql = "SELECT rekanan_id,rekanan_name,rekanan_badanhukum  FROM master_rekanan 
					WHERE rekanan_name LIKE '%". $criteria ."%'";

			$this->load->model("ibos/transbrowser/mdl_transbrowser");
			$response = $this->mdl_transbrowser->_custom_query($sql);
                        
			$json = array();
			foreach($response->result() as $rows){
				$json[] = array('id' => trim(strtoupper($rows->rekanan_id)), 'text'=> strtoupper($rows->rekanan_name).",".strtoupper($rows->rekanan_badanhukum));
			}
			echo json_encode($json);
		}
                
		public function getaccount_select2(){
			//$id = empty($_GET['id']) ? ' ' : $_GET['id'];
			$criteria = empty($_GET['q']) ? ' ' : $_GET['q'];
			

			// Hardcoded exclude Used Items Solutions base on needs.
			$sql = "SELECT acc_id,acc_name  FROM master_acc 
					WHERE acc_id LIKE '%". $criteria ."%' 
					OR acc_name LIKE '%". $criteria ."%'";

			$this->load->model("ibos/transbrowser/mdl_transbrowser");
			$response = $this->mdl_transbrowser->_custom_query($sql);
			
			$json = array();
			foreach($response->result() as $rows){
				$json[] = array('id' => trim(strtoupper($rows->acc_id)), 'text'=> trim(strtoupper($rows->acc_id)) . '-' . strtoupper($rows->acc_name));
			}
			echo json_encode($json);
		}
                
		public function fillcombogroupaccount(){
			// Hardcoded exclude Used Items Solutions base on needs.
			$sql = "select setting_value, setting_value2 from master_settingweb where setting_module='trial-balance' and setting_name='group-account'";

			$this->load->model("ibos/transbrowser/mdl_transbrowser");
			$response = $this->mdl_transbrowser->_custom_query($sql);
			
			$options = array('' => '-- Pilih --');  
			foreach($response->result() as $rows){
				$options[$rows->setting_value] = $rows->setting_value2;
			}
			
			return $options;
		}
                
		public function getaccount_select(){
			// Hardcoded exclude Used Items Solutions base on needs.
			$sql = "SELECT acc_id,acc_name  FROM master_acc ";

			$response = $this->db->query($sql);

			$options = array('' => '-- Pilih --');   
			foreach($response->result() as $rows){
                                $options[$rows->acc_id] = $rows->acc_id . '-' . $rows->acc_name;
				//$json[] = array('id' => trim(strtoupper($rows->acc_id)), 'text'=> trim(strtoupper($rows->acc_id)) . '-' . strtoupper($rows->acc_name));
			}
                                        
			return $options;
		}
                
                
                public function getstore_select2() {
                    $criteria = empty($_POST['q']) ? '' : $_POST['q'];
                    //$region_id = empty($_POST['region']) ? '' : $_POST['region'];

                    // Hardcoded exclude Used Items Solutions base on needs.
                    $sql = "SELECT b.branch_id,branch_name FROM master_branch b left join master_regionbranch rb on b.branch_id=rb.branch_id
                                    WHERE branch_name LIKE '%" . $criteria . "%' ";// . (empty($region_id) ? "" : "AND region_id='$region_id' ");

                    $this->load->model("ibos/transbrowser/mdl_transbrowser");
                    $response = $this->mdl_transbrowser->_custom_query($sql);

                    $json = array();
                    foreach ($response->result() as $rows) {
                        $json[] = array('id' => trim(strtoupper($rows->branch_id)), 'text' => trim(strtoupper($rows->branch_name)));
                    }
                    echo json_encode($json);
                }
            public function getresult(){
                echo "1";
            }
	
	}								