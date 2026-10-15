<!DOCTYPE html>
<html>
  
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
      Trans Retail | Web Application
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
     <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('assets/dist/img/fave-ico.png');?>">
    <!-- Bootstrap 3.3.6 -->
    
    <link href="<?php echo base_url('assets/plugins/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/plugins/simple-line-icons/simple-line-icons.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/components.min.css');?>" rel="stylesheet" id="style_components" type="text/css" />
    <link href="<?php echo base_url('assets/css/layout.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/themes/darkblue.min2.css');?>" rel="stylesheet" type="text/css" id="style_color" />
   
    <link href="<?php echo base_url('assets/plugins/datatables/datatables.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css');?>" rel="stylesheet" type="text/css" />

  	<link href="<?php echo base_url('assets/plugins/select2/css/select2.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/plugins/select2/css/select2-bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/plugins/jquery-file-upload/css/jquery.fileupload.css');?>" rel="stylesheet" type="text/css" />
   
    <script src="<?php echo base_url('assets/plugins/jquery.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/select2/js/select2.full.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/js.cookie.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/jquery.blockui.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/scripts/datatable.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/datatables/datatables.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/scripts/app.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/scripts/table-datatables-buttons.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/scripts/layout.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/scripts/jquery.number.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/jsinternal/jsgrid.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/scripts/jqBootstrapValidation.js');?>"></script>
 

 <link href="<?php echo base_url('assets/css/fixedColumns.bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
  <script src="<?php echo base_url('assets/scripts/dataTables.fixedColumns.min.js');?>" type="text/javascript"></script>
 
    <script src="<?php echo base_url('assets/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/jquery-file-upload/js/vendor/load-image.min.js');?>" type="text/javascript"></script>  
    <script src="<?php echo base_url('assets/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/jquery-file-upload/js/jquery.iframe-transport.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/jquery-file-upload/js/jquery.fileupload.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/jquery-file-upload/js/jquery.fileupload-process.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/jquery-file-upload/js/jquery.fileupload-image.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/jquery-file-upload/js/jquery.fileupload-validate.js');?>" type="text/javascript"></script>
        
	<style>
		.modal-header{
    		background-color: #3498db;
		}

		.modal-title{
    		color: white;
		}
		.modal-dialog{
    		padding-top: 0px;
		}
		label {
    		margin-bottom: 0px !important;
		}

		.form-group {
   		 	margin-bottom: 1px !important;
		}
		.nogaris {border-style:none;}

table.dataTable tr {
    cursor: pointer; 
}


</style>
<script>        
 $(document).ready(function() {
 //Date picker
            $('#coll_date').datepicker({
                format: "yyyy-mm-dd",
				minView : 2,
                autoclose: true
            })
 })

</script>
  </head>
 <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-content-white">
    <div class="page-wrapper">
      <div class="page-header navbar navbar-fixed-top">
        <div class="page-header-inner">
          <!-- BEGIN LOGO -->
          <div class="page-logo" valign="top">
            <a href="<?php echo base_url('index.php/dashboard'); ?>">
            <img src="<?php echo base_url('assets/img/ebyt.png');?>" alt="logo" class="logo-default" /></a>
            <div class="menu-toggler sidebar-toggler">
              <i class="fa fa-bars" aria-hidden="true" style="color: white;">
              </i>
            </div>
          </div>
          <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
          <i class="fa fa-bars" aria-hidden="true" style="color: white;"></i>
          </a>
          <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
              <li class="dropdown dropdown-user">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                <img alt="" class="img-circle" src="<?php echo base_url('assets/img/avatar3_small.jpg');?>" />
                <span class="username username-hide-on-mobile" style="color: white;"> <strong>WELCOME</strong> : <?php echo $this->session->userdata['user_fullname'];?> </span>
                <i class="fa fa-angle-down" style="color: yellow;"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-default">
                <li>
                    <a href="<?php echo base_url('index.php/dashboard'); ?>">
                    <i class="icon-home"></i> Dashboard </a>
                  </li>
                  <li>
                    <a href="#">
                    <i class="icon-user"></i> My Profile </a>
                  </li>
                  <li>
                    <a href="<?php  echo base_url() . custom_constants::logout_url; ?>">
                    <i class="icon-key"></i> Log Out </a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="clearfix">
      </div>
      <div class="page-container">
        <div class="page-sidebar-wrapper">
          <div class="page-sidebar navbar-collapse collapse">
            <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-light " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
              <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                  <span>
                  </span>
                </div>
              </li>

              
               <li class="nav-item">
                <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-briefcase"></i>
                <span class="title">Floor Plan</span>
                <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                 
                  <?php echo getMenuloo();?>
                  
                  
                </ul>
                
              </li>

              <li class="nav-item start">
                <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-puzzle"></i>
                <span class="title">Agreement</span>
                <span class="selected"></span>
                <span class="arrow open"></span>
                </a>
                <ul class="sub-menu">              
                  <li class="nav-item">
                    <a href="<?php echo base_url('index.php/agreement/agreement/agreementlist'); ?>" class="nav-link ">
                      <span class="title">Agreement Transaction</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo base_url('index.php/casual/casual/casuallist'); ?>" class="nav-link ">
                      <span class="title">Agreement Transaction Casual</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo base_url('index.php/agreement/agreementapp/agreementapplist'); ?>" class="nav-link ">
                      <span class="title">Agreement Transaction Posting</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo base_url('index.php/agreement/agreementunapp/agreementunapplist'); ?>" class="nav-link ">
                      <span class="title">Agreement Transaction Unposting</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo base_url('index.php/casual/casualapp/casualapplist'); ?>" class="nav-link ">
                      <span class="title">Profit Sharing Posting</span>
                    </a>
                  </li>
		  <li class="nav-item">
                    <a href="<?php echo base_url('index.php/casual/casualpost/casualpostlist'); ?>" class="nav-link ">
                      <span class="title">Agreement Transaction Casual Posting</span>
                    </a>
                  </li>
                </ul>
              </li>
              
               <li class="nav-item start">
                <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-puzzle"></i>
                <span class="title">LOO</span>
                <span class="selected"></span>
                <span class="arrow open"></span>
                </a>
                <ul class="sub-menu">
                
                 <li class="nav-item">
                     <a href="<?php echo base_url('index.php/loo_cl/loo_cl/penalist'); ?>" class="nav-link ">
                    <span class="title">Proposed LOO ATM</span>
                    </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/loo_cl/looapp_cl/looapplist'); ?>" class="nav-link ">
                    <span class="title">Proposed LOO ATM Approval</span>
                    </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/loo_cl/loo_cl/loolist'); ?>" class="nav-link ">
                    <span class="title">LOO ATM Print</span>
                    </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/loo_bts/loo/loolist'); ?>" class="nav-link ">
                    <span class="title">LOO BTS</span>
                    </a>
                  </li>
                 
                  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/loo/loo'); ?>" class="nav-link ">
                    <span class="title">LOO Permanent/Casual</span>
                    </a>
                  </li>
                 
                  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/loo/looapp'); ?>" class="nav-link ">
                    <span class="title">LOO Permanent/Casual Approval</span>
                    </a>
                  </li>
				  
				  <?php if($this->session->userdata('username') == 'administrator') { ?>
					        <li class="nav-item">
                     <a href="<?php echo base_url('index.php/loo/looapp/loounapplist'); ?>" class="nav-link ">
                    <span class="title">LOO Permanent/Casual UnApproval</span>
                    </a>
                  </li>
				  <?php } ?>  
				  
                  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/upload/uploaddoc/uploadlist'); ?>" class="nav-link ">
                    <span class="title">Upload Documents</span>
                    </a>
                  </li>
  
                  <li class="nav-item">
                    <a href="<?php echo base_url('index.php/loi_received/loi_received/loi_status'); ?>" class="nav-link ">
                    <span class="title">LOI Received</span>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="<?php echo base_url('index.php/la_received'); ?>" class="nav-link ">
                    <span class="title">LA Received</span>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="<?php echo base_url('index.php/legal_upload/legal_list'); ?>" class="nav-link ">
                    <span class="title">LA Upload</span>
                    </a>
                  </li>
                  
                 
                </ul>
              </li>
              
              <li class="nav-item start">
                <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-puzzle"></i>
                <span class="title">LOC</span>
                <span class="selected"></span>
                <span class="arrow open"></span>
                </a>
                <ul class="sub-menu">
                                  
                   <li class="nav-item">
                    <a href="<?php echo base_url('index.php/loc/loc/loclist'); ?>" class="nav-link ">
                    <span class="title">LOC</span>
                    </a>
                  </li>
                  
                   <li class="nav-item">
                    <a href="<?php echo base_url('index.php/loc_atm/loc_atm/penalist'); ?>" class="nav-link ">
                    <span class="title">LOC ATM</span>
                    </a>
                  </li>
                  
                   <li class="nav-item">
                    <a href="<?php echo base_url('index.php/loc_bts/loc_bts/loclist'); ?>" class="nav-link ">
                    <span class="title">LOC BTS</span>
                    </a>
                  </li>
                  
                  <li class="nav-item">
                    <a href="<?php echo base_url('index.php/loc/locapp'); ?>" class="nav-link ">
                    <span class="title">LOC Approval</span>
                    </a>
                  </li>

				   <?php if($this->session->userdata('username') == 'administrator') { ?>
					   <li class="nav-item">
						<a href="<?php echo base_url('index.php/loc/locunapp'); ?>" class="nav-link ">
						<span class="title">LOC UnApproval</span>
						</a>
					  </li>
				  <?php } ?>
				
                </ul>
              </li>
             
              <li class="nav-item start">
              <a href="javascript:;" class="nav-link nav-toggle">
              <i class="icon-puzzle"></i>
                <span class="title">LOO Casual</span>
                <span class="selected"></span>
                <span class="arrow open"></span>
                </a>
                <ul class="sub-menu">
                  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/loocasual/loocasual/loocasuallist'); ?>" class="nav-link ">
                    <span class="title">LOO Casual</span>
                    </a>
                  </li>
                  
                   <li class="nav-item">
                     <a href="<?php echo base_url('index.php/loocasual/loocasualapp/loocasualapplist'); ?>" class="nav-link ">
                    <span class="title">LOO Casual Approval</span>
                    </a>
                  </li>
                  
                </ul>
              </li>
  
              
              
              <li class="nav-item start">
              <a href="javascript:;" class="nav-link nav-toggle">
              <i class="icon-puzzle"></i>
                <span class="title">Report</span>
                <span class="selected"></span>
                <span class="arrow open"></span>
                </a>
                <ul class="sub-menu">
                 <li class="nav-item">
                     <a href="<?php echo base_url('index.php/jurnalsummary/pgsummary'); ?>" class="nav-link ">
                    <span class="title">Trial Balance</span>
                    </a>
                  </li>
                  
                 <li class="nav-item">
                     <a href="<?php echo base_url('index.php/va_download'); ?>" class="nav-link ">
                    <span class="title">Virtual Account Download</span>
                    </a>
                  </li>
                   <li class="nav-item">
                     <a href="<?php echo base_url('index.php/soa/soa/soalist'); ?>" class="nav-link ">
                    <span class="title">Statement Of Account</span>
                    </a>
                  </li>
				    <li class="nav-item">
                     <a href="<?php echo base_url('index.php/summary_soa'); ?>" class="nav-link ">
                    <span class="title">Statement Of Account Summary</span>
                    </a>
                  </li>
                   <li class="nav-item">
                     <a href="<?php echo base_url('index.php/soprpt/soprpt/soprptlist'); ?>" class="nav-link ">
                    <span class="title">Schedule of Payment</span>
                    </a>
                  </li>
                   <li class="nav-item">
                     <a href="<?php echo base_url('index.php/schedule_payment/sp_list'); ?>" class="nav-link ">
                    <span class="title">Schedule of Payment Grid</span>
                    </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/payment_history/payment'); ?>" class="nav-link ">
                    <span class="title">Payment (THD) Report</span>
                    </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/lareport/lareport/lalist'); ?>" class="nav-link ">
                    <span class="title">Letter Agreement Report (New)</span>
                    </a>
                  </li>
                   <li class="nav-item">
                     <a href="<?php echo base_url('index.php/lareport/lareportrn/lalist'); ?>" class="nav-link ">
                    <span class="title">Letter Agreement Report (Renewal)</span>
                    </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/loi/loi/loilist'); ?>" class="nav-link ">
                    <span class="title">LOI</span>
                    </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/Smreport/Smreport/rptloila_new'); ?>" class="nav-link ">
                    <span class="title">Status LOI-LA New Property</span>
                    </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/Smreport/Smreport/rptlapaydp'); ?>" class="nav-link ">
                    <span class="title">Status Invoicing-Paymentl000</span>
                    </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/Smreport/Smreport/rptlatenantnew'); ?>" class="nav-link ">
                    <span class="title">Status LOI-LA Existing Property</span>
                    </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/tenant_history/tenant_history_data'); ?>" class="nav-link ">
                    <span class="title">Tenant Historical Data (THD)</span>
                    </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/tenant_history/tenant_thd_summary'); ?>" class="nav-link ">
                    <span class="title">Monitoring Tenant Summary</span>
                    </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/proforma/rProfo'); ?>" class="nav-link ">
                    <span class="title">Proforma Invoice Report</span>
                    </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/aging'); ?>" class="nav-link ">
                    <span class="title">Aging Report</span>
                    </a>
                  </li>
				  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/tenancyrpt/tenancyrpt/tenancyrptlist'); ?>" class="nav-link ">
                    <span class="title">Tenancy Contract Listing</span>
                    </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/taxledger/taxledger/taxledgerlist'); ?>" class="nav-link ">
                    <span class="title">Tax Ledger</span>
                    </a>
                  </li>
				  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/buktipotong/buktipotong/buktipotonglist'); ?>" class="nav-link ">
                    <span class="title">Withholding Tax Slip Report</span>
                    </a>
                  </li>
				  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/Monthlyinvoice/Monthlyinvoice/Monthlyinvoicelist'); ?>" class="nav-link ">
                    <span class="title">Monthly Invoice List</span>
                    </a>
                  </li>
				  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/interfaceps/interfaceps/interfacepslist'); ?>" class="nav-link ">
                    <span class="title">Download Interface PS</span>
                    </a>
                  </li>
				  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/pajakkeluaran/pajakkeluaran/pajakkeluaranlist'); ?>" class="nav-link ">
                    <span class="title">Download Faktur Pajak Keluaran</span>
                    </a>
                  </li>
				  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/billingorder/billingorder/billingorderlist'); ?>" class="nav-link ">
                    <span class="title">Virtual Account Billing Report</span>
                    </a>
                  </li>		
				  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/virtualaccount/virtualaccount/virtualaccountlist'); ?>" class="nav-link ">
                    <span class="title">Virtual Account List</span>
                    </a>
                  </li>
				  
                  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/ar_forecast'); ?>" class="nav-link ">
                    <span class="title">A/R Forecast Report</span>
                    </a>
                  </li>
				  
				   <li class="nav-item">
                     <a href="<?php echo base_url('index.php/paymenttype_report'); ?>" class="nav-link ">
                    <span class="title">Payment Report By Tenant By Property</span>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-item start">
              <a href="javascript:;" class="nav-link nav-toggle">
              <i class="icon-puzzle"></i>
                <span class="title">Invoicing</span>
                <span class="selected"></span>
                <span class="arrow open"></span>
                </a>
                <ul class="sub-menu">
                 <li class="nav-item">
                     <a href="<?php echo base_url('index.php/invoicing/invoice/invoicelist'); ?>" class="nav-link ">
                    <span class="title">Invoicing</span>
                    </a>
                  </li>
                 <li class="nav-item">
                     <a href="<?php echo base_url('index.php/invoicing/invoice/invoicecancellist'); ?>" class="nav-link ">
                    <span class="title">Invoicing Cancel</span>
                    </a>
                  </li>      
                  
                  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/invoicing/invoice/invoicepostinglist'); ?>" class="nav-link ">
                    <span class="title">Invoice Posting Jurnal</span>
                    </a>
                  </li>
                  
                   <li class="nav-item">
                     <a href="<?php echo base_url('index.php/invoicing/invoice/invoiceunpostinglist'); ?>" class="nav-link ">
                    <span class="title">Invoice Unposting Jurnal</span>
                    </a>
                  </li>
                 <li class="nav-item">
                     <a href="<?php echo base_url('index.php/invoicing/invoice/invoiceprintprolist'); ?>" class="nav-link ">
                    <span class="title">Invoicing Print Out (Proforma)</span>
                    </a>
                  </li>
                 <li class="nav-item">
                     <a href="<?php echo base_url('index.php/invoicing/invoice/invoiceprintinvlist'); ?>" class="nav-link ">
                    <span class="title">Invoicing Print Out (Invoice)</span>
                    </a>
                  </li>         
                </ul>
              </li>
              
              <li class="nav-item start">
              <a href="javascript:;" class="nav-link nav-toggle">
              <i class="icon-puzzle"></i>
                <span class="title">Utilities</span>
                <span class="selected"></span>
                <span class="arrow open"></span>
                </a>
                <ul class="sub-menu">
                 <li class="nav-item">
                     <a href="<?php echo base_url('index.php/listrik/listrik/listriklist'); ?>" class="nav-link ">
                    <span class="title">Listrik</span>
                    </a>
                  </li> 
                  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/listrik/listrikapp/listrikapplist'); ?>" class="nav-link ">
                    <span class="title">Posting Listrik</span>
                    </a>
                  </li> 
                  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/listrik/listrikunapp/listrikunapplist'); ?>" class="nav-link ">
                    <span class="title">Unposting Listrik</span>
                    </a>
                  </li>                                                                                                
                </ul>
              </li>
                            
             <li class="nav-item start">
              <a href="javascript:;" class="nav-link nav-toggle">
              <i class="icon-puzzle"></i>
                <span class="title">Payment</span>
                <span class="selected"></span>
                <span class="arrow open"></span>
                </a>
                <ul class="sub-menu">
                 <li class="nav-item">
                     <a href="<?php echo base_url('index.php/ormall/ormall/orlist'); ?>" class="nav-link ">
                    <span class="title">Input Official Receipt - Mall</span>
                    </a>
                  </li>
                 <li class="nav-item">
                     <a href="<?php echo base_url('index.php/jvoucher/jvoucher/jvoucherlist'); ?>" class="nav-link ">
                    <span class="title">Entry Journal</span>
                    </a>
                  </li>
                 <li class="nav-item">
                     <a href="<?php echo base_url('index.php/jvoucher/jvoucherapp/jvoucherapplist'); ?>" class="nav-link ">
                    <span class="title">Journal Posting</span>
                    </a>
                  </li>                        
                  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/jvoucher/jvoucherapp/jvoucherunapplist'); ?>" class="nav-link ">
                    <span class="title">Journal Unposting</span>
                    </a>
                  </li>                        
                </ul>
              </li>



              <li class="nav-item start">
              <a href="javascript:;" class="nav-link nav-toggle">
              <i class="icon-puzzle"></i>
                <span class="title">Tools</span>
                <span class="selected"></span>
                <span class="arrow open"></span>
                </a>
                <ul class="sub-menu">
                  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/simpay'); ?>" class="nav-link ">
                    <span class="title">Payment Simulation</span>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-item start">
              <a href="javascript:;" class="nav-link nav-toggle">
              <i class="icon-puzzle"></i>
                <span class="title">Referential Settings</span>
                <span class="selected"></span>
                <span class="arrow open"></span>
                </a>
                <ul class="sub-menu">
                <li class="nav-item">
                     <a href="<?php echo base_url('index.php/unit'); ?>" class="nav-link ">
                    <span class="title">Master Unit</span>
                    </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/master_rekanan/index'); ?>" class="nav-link ">
                    <span class="title">Master Tenat/Shopname</span>
                    </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/master_branch/index'); ?>" class="nav-link ">
                    <span class="title">Master Branch</span>
                    </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo base_url('index.php/semester'); ?>" class="nav-link ">
                    <span class="title">Master Semester Property</span>
                    </a>
                  </li>
				  
                   <li class="nav-item">
                     <a href="<?php echo base_url('index.php/taxnumber/taxnumber/taxnumberlist'); ?>" class="nav-link ">
                    <span class="title">Master Tax Number</span>
                    </a>
                  </li>
                  
                   <li class="nav-item">
                     <a href="<?php echo base_url('index.php/taxbranch/taxbranch/taxbranchlist'); ?>" class="nav-link ">
                    <span class="title">Master Tax Branch</span>
                    </a>
                  </li>
				  
                </ul>
              </li>
              
              <?php if (($this->session->userdata['username']=='harris') or ($this->session->userdata['username']=='chairul.anwar') or ($this->session->userdata['username']=='nurmelia')){ ?>
              
               <li class="nav-item">
                  <a href="<?php echo base_url('index.php/agreement_close'); ?>" class="nav-link nav-toggle">
                  <i class="icon-puzzle"></i>
                  <span class="title">Tenant Pull Out</span>
                  <span class="selected"></span>
                  </a>
                </li>
              </li>
              <?php } ?>
            </ul>
          </div>
        </div>
        
        <div class="page-content-wrapper">
          <div class="page-content">
            <div class="page-bar">
              <br>
              <?php echo $this->breadcrumbcomponent->show() ?>
               </div>
            <br />