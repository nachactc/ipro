<link href="<?php echo base_url('assets/plugins/morris/morris.css'); ?>" rel="stylesheet" type="text/css" />  
<link href="<?php echo base_url('assets/css/plugins.min.css'); ?>" rel="stylesheet" type="text/css" />  
<link href="<?php echo base_url('assets/css/custom.min.css'); ?>" rel="stylesheet" type="text/css" />     

<style>
.blink{ 
	color: rgb (0, 137, 226); 
	animation: blink 1s infinite;
}
@keyframes blink{
	0%{opacity: 1;}
	75%{opacity: 1;}
	76%{ opacity: 0;}
	100%{opacity: 0;}
}
.amcharts-chart-div a {display:none !important;}


#chartdivTenant {
  width: 365px;
  height: 400px;
  font-size: 11px;
  border: 1px solid #eee;
  float: left;
  margin-left: 15px;
}

#legend {
  width: 200px;
  height: 400px;
  border: 1px solid #eee;
  margin-left: 15px;
  float: left;
}

#legend .legend-item {
  margin: 10px;
  font-size: 15px;
  font-weight: bold;
  cursor: pointer;
}

#legend .legend-item .legend-value {
  font-size: 12px;
  font-weight: normal;
  margin-left: 22px;
}

#legend .legend-item .legend-marker {
  display: inline-block;
  width: 12px;
  height: 12px;
  border: 1px solid #ccc;
  margin-right: 10px;
}

#legend .legend-item.disabled .legend-marker {
  opacity: 0.5;
  background: #ddd;
}
</style>	
			<div class="caption">
			  <i class="icon-cursor font-dark hide">
			  </i>
			  <span class="caption-subject font-dark bold uppercase">
			  Tenant Renewal
			  </span>
			  <span> &nbsp; </span>
			</div>
			<!-- reminder -->
			<div class="row">
			
              <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 ">
                  <div class="display">
                    <div class="number">
                      <h3 class="font-red-haze"> 
                        <small class="font-red-haze">
						<span data-counter="counterup" data-value="<?php echo $reminder_1bln; ?>">
                          0 </span> 
                        </small>
                      </h3>
                      <small class="font-red-haze blink">
                      Warning!  
                      </small>
                    </div>
                    <div class="icon">
                      <i class="font-red-haze glyphicon glyphicon-warning-sign blink">
                      </i>
                    </div>
                  </div>
                  <div class="progress-info">
                    <div class="progress">
                      <span style="width: <?php echo $reminder_1bln; ?>%;" class="progress-bar progress-bar-success red-haze">
                        <span class="sr-only ">
                          <?php echo $reminder_1bln; ?> 
                        </span>
                      </span>
                    </div>
                    <div class="status">
                      <div class="status-title font-red-haze">
                        1 Month Notice   
                      </div>
                      <div class="status-number font-red-haze"> 
						 <a class="status-title font-red-haze blink" href="<?php echo $link_1bln; ?>" target="_blank">  
						 <?php echo $reminder_1bln; ?>
                          <i class="icon-arrow-right "></i>
                          </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
			  
              <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 ">
                  <div class="display">
                    <div class="number">
                      <h3 class="font-blue-sharp">
                        <span data-counter="counterup" data-value="<?php echo $reminder_3bln; ?>">
                          0
                        </span>
                      </h3>
                      <small class="font-blue-sharp ">
                       Warning!
                      </small>
                    </div>
                    <div class="icon">
                      <i class="font-blue-sharp glyphicon glyphicon-warning-sign">
                      </i>
                    </div>
                  </div>
                  <div class="progress-info">
                    <div class="progress">
                      <span style="width: <?php echo $reminder_3bln; ?>%;" class="progress-bar progress-bar-success blue-sharp">
                        <span class="sr-only">
                          <?php echo $reminder_3bln; ?>
                        </span>
                      </span>
                    </div>
                    <div class="status">
                      <div class="font-blue-sharp status-title">
                        3 Month Notice
                      </div>
                      <div class="status-number font-blue-sharp">
						<a class="status-title font-blue-sharp" href="<?php echo $link_3bln; ?>" target="_blank">  
						 <?php echo $reminder_3bln; ?>
                          <i class="icon-arrow-right"></i>
                          </a> 
                      </div>
                    </div>
                  </div>
                </div>
              </div>
			 
              <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 ">
                  <div class="display">
                    <div class="number">
                      <h3 class="font-purple-soft">
                        <span data-counter="counterup" data-value="<?php echo $reminder_6bln; ?>">
                        </span>
                      </h3>
                      <small class="font-purple-soft ">
                       WARNING!
                      </small>
                    </div>
                    <div class="icon">
                      <i class="glyphicon glyphicon-warning-sign font-purple-soft">
                      </i>
                    </div>
                  </div>
                  <div class="progress-info">
                    <div class="progress">
                      <span style="width: 45%;" class="progress-bar progress-bar-success purple-soft">
                        <span class="sr-only ">
                         <?php echo $reminder_3bln; ?>
                        </span>
                      </span>
                    </div>
                    <div class="status">
                      <div class="status-title font-purple-soft">
                        6 Month Notice
                      </div>
                      <div class="status-number font-purple-soft"> 
						<a class="status-title font-purple-soft" href="<?php echo $link_6bln; ?>" target="_blank">  
						 <?php echo $reminder_6bln; ?>
                          <i class="icon-arrow-right"></i>
                          </a> 
                      </div>
                    </div>
                  </div>
                </div>
              </div>
			   <!--font-green-sharp-->
              <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 ">
                  <div class="display">
                    <div class="number">
                      <h3 class="font-green-sharp">
                        <span data-counter="counterup" data-value="<?php echo $reminder_12bln; ?>">
                        </span>
                      </h3>
                      <small class="font-green-sharp ">
                      WARNING!
                      </small>
                    </div>
                    <div class="icon font-green-sharp">
                      <i class="glyphicon glyphicon-warning-sign  font-green-sharp">
                      </i>
                    </div>
                  </div>
                  <div class="progress-info">
                    <div class="progress">
                      <span style="width: <?php echo $reminder_12bln; ?>%;" class="progress-bar progress-bar-success green-sharp" >
                        <span class="sr-only">
                          <?php echo $reminder_12bln; ?>
                        </span>
                      </span>
                    </div>
                    <div class="status">
                      <div class="status-title font-green-sharp">
                        12 Month Notice
                      </div>
                      <div class="status-number font-green-sharp">
                        <a class="status-title font-green-sharp" href="<?php echo $link_12bln; ?>" target="_blank">  
						 <?php echo $reminder_12bln; ?>
                          <i class="icon-arrow-right"></i>
                          </a> 
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
			<!-- reminder -->
		 
		
		   <!-- payment and invoicing --> 
		   <!--all-->
			 <div class="caption">
			  <i class="icon-cursor font-dark hide">
			  </i>
			  <span class="caption-subject font-dark bold ">
			  Periode 
			  <?php echo date('M-Y').' '.date('M-Y',strtotime('-1 month', time())).' '.date('M-Y',strtotime('-2 month', time())).' '.date('M-Y',strtotime('-3 month', time())) ; ?>
			  </span>
			  <span> &nbsp; </span>
			</div>
			<div class="row">
              <div class="col-md-3">
                <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                  <h4 class="widget-thumb-heading">
                    Outstanding 
                  </h4>
                  <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-purple icon-screen-desktop">
                    </i>
                    <div class="widget-thumb-body">
                      <span class="widget-thumb-subtitle">
                        Total
                      </span>
                     <small > <span style="font-size:17px;" class="widget-thumb-body-stat" data-counter="counterup" data-value="<?php echo $outstanding; ?>">
                        0
                      </span></small>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                  <h4 class="widget-thumb-heading">
                   Outstanding Payment
                  </h4>
                  <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-red icon-layers">
                    </i>
                    <div class="widget-thumb-body">
                      <span class="widget-thumb-subtitle">
                        IDR
                      </span>
                     <small> 
					 <span style="font-size:17px;"  class="widget-thumb-body-stat" data-counter="counterup" data-value="<?php echo number_format ($total_outstanding,2); ?>">
                        0
                      </span></small>
                    </div>
                  </div>
                </div>
              </div>
			  <div class="col-md-3">
                <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                  <h4 class="widget-thumb-heading">
                    Invoice
                  </h4>
                  <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-green icon-bulb">
                    </i>
                    <div class="widget-thumb-body">
                      <span class="widget-thumb-subtitle">
                        Total
                      </span>
                      <span style="font-size:15px;"  class="widget-thumb-body-stat" data-counter="counterup" data-value="<?php echo $total_invoice; ?>">
                        0
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                  <h4 class="widget-thumb-heading">
                    Payment Invoice
                  </h4>
                  <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-blue icon-bar-chart">
                    </i>
                    <div class="widget-thumb-body">
                      <span class="widget-thumb-subtitle">
                        TOTAL
                      </span>
					  <small>
                      <span style="font-size:15px;"  class="widget-thumb-body-stat" data-counter="counterup" data-value="<?php echo number_format($payment_invoice,2); ?>">
                        0
                      </span>
					  </small>
                    </div>
                  </div>
                </div>
              </div>
             
			</div>
           <!-- all --> 
		     <!-- payment and invoicing -->
			
		  
			<!-- grafik-->			
            <div class="row"> 
			<div class="col-md-6" align="center">
				<div class="sparkline-chart"> <a class="title" href="javascript:;"> Agreement Posting 
				  </a>
				 <div id="chartdiv"  class="center" style="width: 385px; height: 200px;"></div>  
				</div>
			</div>
			 <div class="margin-bottom-35 visible-sm"> </div>
			<div class="col-md-6" align="center">
				<div class="sparkline-chart"> <a class="title" href="javascript:;"> Invoice <?php echo date('M').'-'.date('Y'); ?> 
				  </a>
				 <div id="chartdivInv" align="center" style="width: 385px; height: 200px;"></div> 
				</div>
			</div>
			<!-- grafik-->
			</div>
			 
			
			<!-- status rekanan -->
			<div class="row">
              <div class="col-lg-12 col-xs-12 col-sm-12">
                <div class="portlet light bordered">
                  <div class="portlet-title">
                    <div class="caption">
                      <i class="icon-cursor font-dark hide">
                      </i>
                      <span class="caption-subject font-dark bold uppercase" data-toggle="collapse" data-target="#tenant">
                        Data Tenant Not Completed
                      </span>
                    </div>
                  </div>
				 <!-- trp -->
				  <!--<div id="tenant" class="collapse">-->
                  <div class="portlet-body">
				  <span class="caption-subject font-dark bold uppercase">
                    
                   </span>
                    <div class="row">
					
					 <div id="chartdivTenant" ></div> 
					 <div id="legend" ></div>
					</div>
                  <!--</div>-->
                  <!-- trp -->
				  </div>
				</div>
              </div>
              </div>
			<!-- status rekanan -->
			 
			<!-- status loo -->
			<div class="row">
              <div class="col-lg-12 col-xs-12 col-sm-12">
                <div class="portlet light bordered">
                  <div class="portlet-title">
                    <div class="caption">
                      <i class="icon-cursor font-dark hide">
                      </i>
                      <span class="caption-subject font-dark bold uppercase" data-toggle="collapse" data-target="#loo">
                        Status loo ( <?php echo date("Y") ; ?> )
                      </span>
                    </div>
                  </div>
				  <!--<div id="loo" class="collapse">-->
				  <!-- trp -->
                  <div class="portlet-body">
				  <span class="caption-subject font-dark bold uppercase">
                   Trans Ritel Properti ( TRP ) ( Total : <?php echo $dataLooAll_trp; ?> LOO)
                   </span>
                    <div class="row">
					
                      <div class="col-md-4">
                        <div class="easy-pie-chart">
                          <div class="number visits" data-percent="<?php echo $dataBaruLoo_trp; ?>">
                            <span>
                             <?php echo $dataBaruLoo_trp; ?>
                            </span>
                            
                          </div>
                           New LOO 
                        </div>
                      </div>
                      <div class="margin-bottom-10 visible-sm">
                      </div>
                      <div class="col-md-4">
                        <div class="easy-pie-chart">
                          <div class="number transactions" data-percent="<?php echo $approveLoo_trp; ?>">
                            <span>
                              <?php echo $approveLoo_trp; ?>
                            </span> 
                          </div>
                          <a class="title" href="javascript:;"> LOO Approve
                          
                          </a>
                        </div>
                      </div>
                      <div class="margin-bottom-10 visible-sm">
                      </div>
                      <div class="col-md-4">
                        <div class="easy-pie-chart">
                          <div class="number bounce" data-percent="<?php echo $dataLooProcess_trp; ?>">
                            <span>
                              <?php echo $dataLooProcess_trp; ?>
                            </span> 
                          </div>
                          <a class="title" href="javascript:;"> LOO Process
                          
                          </a>
                        </div>
                      </div>
					   <div class="col-md-4">
                        <div class="easy-pie-chart">
                          <div class="number visits" data-percent="<?php echo $dataLooSent_trp; ?>">
                            <span>
                              <?php echo $dataLooSent_trp; ?>
                            </span> 
                          </div>
                          <a class="title" href="javascript:;"> LOO Sent
                          
                          </a>
                        </div>
                      </div>
					   <div class="col-md-4">
                        <div class="easy-pie-chart">
                          <div class="number bounce" data-percent="<?php echo $dataLooSign_trp; ?>">
                            <span>
                              <?php echo $dataLooSign_trp; ?>
                            </span> 
                          </div>
                          <a class="title" href="javascript:;"> LOO Sign
                          
                          </a>
                        </div>
                      </div>
					  <div class="col-md-4">
                        <div class="easy-pie-chart">
                          <div class="number transactions" data-percent="<?php echo $dataLooRcv_trp; ?>">
                            <span>
                              <?php echo $dataLooRcv_trp; ?>
                            </span> 
                          </div>
                          <a class="title" href="javascript:;"> LOO Received
                          
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- trp -->
				   <!-- tri -->
				     <div class="portlet-body">
				  <span class="caption-subject font-dark bold uppercase">
                   Trans Retail Indonesia ( TRI ) ( Total : <?php echo $dataLooAll_tri; ?> LOO)
                   </span>
                    <div class="row">
					
                      <div class="col-md-4">
                        <div class="easy-pie-chart">
                          <div class="number visits" data-percent="<?php echo $dataBaruLoo_tri; ?>">
                            <span>
                             <?php echo $dataBaruLoo_tri; ?>
                            </span>
                            
                          </div>
                           New LOO 
                        </div>
                      </div>
                      <div class="margin-bottom-10 visible-sm">
                      </div>
                      <div class="col-md-4">
                        <div class="easy-pie-chart">
                          <div class="number transactions" data-percent="<?php echo $approveLoo_tri; ?>">
                            <span>
                              <?php echo $approveLoo_tri; ?>
                            </span> 
                          </div>
                          <a class="title" href="javascript:;"> LOO Approve
                          
                          </a>
                        </div>
                      </div>
                      <div class="margin-bottom-10 visible-sm">
                      </div>
                      <div class="col-md-4">
                        <div class="easy-pie-chart">
                          <div class="number bounce" data-percent="<?php echo $dataLooProcess_tri; ?>">
                            <span>
                              <?php echo $dataLooProcess_tri; ?>
                            </span> 
                          </div>
                          <a class="title" href="javascript:;"> LOO Process
                          
                          </a>
                        </div>
                      </div>
					   <div class="col-md-4">
                        <div class="easy-pie-chart">
                          <div class="number visits" data-percent="<?php echo $dataLooSent_tri; ?>">
                            <span>
                              <?php echo $dataLooSent_tri; ?>
                            </span> 
                          </div>
                          <a class="title" href="javascript:;"> LOO Sent
                          
                          </a>
                        </div>
                      </div>
					   <div class="col-md-4">
                        <div class="easy-pie-chart">
                          <div class="number transactions" data-percent="<?php echo $dataLooSign_tri; ?>">
                            <span>
                              <?php echo $dataLooSign_tri; ?>
                            </span> 
                          </div>
                          <a class="title" href="javascript:;"> LOO Sign
                          
                          </a>
                        </div>
                      </div>
					  <div class="col-md-4">
                        <div class="easy-pie-chart">
                          <div class="number bounce" data-percent="<?php echo $dataLooRcv_tri; ?>">
                            <span>
                              <?php echo $dataLooRcv_tri; ?>
                            </span> 
                          </div>
                          <a class="title" href="javascript:;"> LOO Received
                          
                          </a>
                        </div>
                      </div>
                    </div>
                  </div> 
				   <!-- tri --> 
				   <!-- ARI -->
				      <div class="portlet-body">
				  <span class="caption-subject font-dark bold uppercase">
                   Alfa Retailindo ( ARI ) ( Total : <?php echo $dataLooAll_ari; ?> LOO)
                   </span>
                    <div class="row">
					
                      <div class="col-md-4">
                        <div class="easy-pie-chart">
                          <div class="number visits" data-percent="<?php echo $dataBaruLoo_ari; ?>">
                            <span>
                             <?php echo $dataBaruLoo_ari; ?>
                            </span>
                            
                          </div>
                           New LOO 
                        </div>
                      </div>
                      <div class="margin-bottom-10 visible-sm">
                      </div>
                      <div class="col-md-4">
                        <div class="easy-pie-chart">
                          <div class="number transactions" data-percent="<?php echo $approveLoo_ari; ?>">
                            <span>
                              <?php echo $approveLoo_ari; ?>
                            </span> 
                          </div>
                          <a class="title" href="javascript:;"> LOO Approve
                          
                          </a>
                        </div>
                      </div>
                      <div class="margin-bottom-10 visible-sm">
                      </div>
                      <div class="col-md-4">
                        <div class="easy-pie-chart">
                          <div class="number bounce" data-percent="<?php echo $dataLooProcess_ari; ?>">
                            <span>
                              <?php echo $dataLooProcess_ari; ?>
                            </span> 
                          </div>
                          <a class="title" href="javascript:;"> LOO Process
                          
                          </a>
                        </div>
                      </div>
					   <div class="col-md-4">
                        <div class="easy-pie-chart">
                          <div class="number visits" data-percent="<?php echo $dataLooSent_ari; ?>">
                            <span>
                              <?php echo $dataLooSent_ari; ?>
                            </span> 
                          </div>
                          <a class="title" href="javascript:;"> LOO Sent
                          
                          </a>
                        </div>
                      </div>
					   <div class="col-md-4">
                        <div class="easy-pie-chart">
                          <div class="number transactions" data-percent="<?php echo $dataLooSign_ari; ?>">
                            <span>
                              <?php echo $dataLooSign_ari; ?>
                            </span> 
                          </div>
                          <a class="title" href="javascript:;"> LOO Sign
                          
                          </a>
                        </div>
                      </div>
					  <div class="col-md-4">
                        <div class="easy-pie-chart">
                          <div class="number bounce" data-percent="<?php echo $dataLooRcv_ari; ?>">
                            <span>
                              <?php echo $dataLooRcv_ari; ?>
                            </span> 
                          </div>
                          <a class="title" href="javascript:;"> LOO Received
                          
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                 <!-- ARI -->
				  <!--</div>-->
				</div>
              </div>
              </div> 
		    <!-- status loo -->
			 
				 
			<!-- status loi -->
			<div class="row">
              <div class="col-lg-12 col-xs-12 col-sm-12">
                <div class="portlet light bordered">
                  <div class="portlet-title">
                    <div class="caption">
                      <i class="icon-cursor font-dark hide">
                      </i>
                      <span class="caption-subject font-dark bold uppercase" data-toggle="collapse" data-target="#loi">
                        Status loi ( <?php echo date("M").'-'.date("Y") ; ?> )
                      </span>
                    </div>
                  </div>
				 <!-- <div id="loi" class="collapse">-->
                  <div class="portlet-body">
				  <span class="caption-subject font-dark bold uppercase">
                   
                   </span>
                    <div class="row">
					
                      <div class="col-md-4">
                        <div class="easy-pie-chart">
                          <div class="number bounce" data-percent="<?php echo $loi; ?>">
                            <span>
                             <?php echo $loi; ?>
                            </span>
                            
                          </div>
                           Waiting For Approval
                        </div>
                      </div>
                      <div class="margin-bottom-10 visible-sm">
                      </div>
                     </div>
                  </div>
                  <!--</div>-->
				
				</div>
              </div>
              </div> 
		    <!-- status loi -->
          
		<!-- graphic -->  
		<script src="<?php echo base_url('assets/plugins/amcharts/amcharts/amcharts.js');?>" type="text/javascript">
		</script>  
		<script src="<?php echo base_url('assets/plugins/amcharts/amcharts/serial.js');?>" type="text/javascript">
		</script>
		<script src="<?php echo base_url('assets/plugins/amcharts/amcharts/pie.js');?>" type="text/javascript">
		</script> 
		<script src="<?php echo base_url('assets/plugins/amcharts/amcharts/themes/light.js');?>" type="text/javascript">
		</script>
		<script src="<?php echo base_url('assets/plugins/moment.min.js');?>" type="text/javascript">
		</script>
		<script src="<?php echo base_url('assets/plugins/bootstrap-daterangepicker/daterangepicker.min.js');?>" type="text/javascript">
		</script>
		<script src="<?php echo base_url('assets/plugins/morris/morris.min.js');?>" type="text/javascript">
		</script>
		<script src="<?php echo base_url('assets/plugins/morris/raphael-min.js');?>" type="text/javascript">
		</script>
		<script src="<?php echo base_url('assets/plugins/counterup/jquery.waypoints.min.js');?>" type="text/javascript">
		</script>
		<script src="<?php echo base_url('assets/plugins/counterup/jquery.counterup.min.js');?>" type="text/javascript">
		</script> 
		<script src="<?php echo base_url('assets/plugins/jquery-easypiechart/jquery.easypiechart.min.js');?>" type="text/javascript">
        </script> 
        <script src="<?php echo base_url('assets/scripts/dashboard.min.js');?>" type="text/javascript">
        </script>
		
<script>
$(document).ready(function(){
//bar chart 	
var jsonData = $.ajax({ 
          url: '<?php echo site_url('dashboard/data_status_agreement'); ?>',
          dataType: "json",
          async: false
          }).responseJSON;
AmCharts.makeChart( "chartdiv", {
	  "type": "serial",
	  "dataProvider": jsonData,
	  "categoryField": "month",
	  "gridAboveGraphs": true,
  "startDuration": 1,
	  "depth3D": 20,
	  "angle": 30,
	 "graphs": [ {
	  "valueField": "total",
	  "type": "column",
	  "fillAlphas": 0.8,
	  "angle": 30,
	  "depth3D": 15,
	  "balloonText": "[[category]]: Total Posting <b>[[value]]</b>"
	} ] 

} );
//bar chart 2 
var jsonDataInv = $.ajax({ 
          url: '<?php echo site_url('dashboard/data_status_invoice'); ?>',
          dataType: "json",
          async: false
          }).responseJSON;  	 
AmCharts.makeChart( "chartdivInv", {
	  "type": "serial",
	  "theme": "light",
	  "gridAboveGraphs": true,
  "startDuration": 1,
	  "dataProvider": jsonDataInv,
	  "depth3D": 20,
  "angle": 30,
	  "categoryField": "month",
	 "graphs": [ {
	  "valueField": "total",
	    "fillAlphas": 0.9,
    "lineAlpha": 0.2,
    "type": "column",
	  "balloonText": "[[category]]: Total <b>[[value]]</b>" 
	} ],
		 "valueAxes": [{
    "gridColor": "#FFFFFF",
    "gridAlpha": 0.2,
    "dashLength": 0
  }],

} );

//pie chart
var jsonDataTenant = $.ajax({ 
          url: '<?php echo site_url('dashboard/get_tenant_status'); ?>',
          dataType: "json",
          async: false
          }).responseJSON;
var chartTenant = AmCharts.makeChart( "chartdivTenant", {
	  "type": "pie",
	  "theme": "light",
	  "dataProvider": jsonDataTenant,
	  "valueField": "litres",
	  "titleField": "country",  
	  "urlField": "url",  
	  "hideCredits":true,
	  "showZeroSlices": true,
	  "balloonText": "[[country]]: [[percents]]% ([[value]])\n[[description]]",
	  "labelText": "[[percents]]%",
	  "labelRadius": -35,
	  "marginTop": 0,
	  "marginBottom": 0
	}); 

chartTenant.addListener('rendered', function(event) {
  // populate our custom legend when chart renders
  chartTenant.customLegend = document.getElementById('legend');
  for (var i in chartTenant.chartData) {
    var row = chartTenant.chartData[i];
    var color = chartTenant.colors[i];
    var percent = Math.round(row.percents * 100) / 100;
    var value = row.value;
    legend.innerHTML += '<div class="legend-item" id="legend-item-' + i + '" onclick="toggleSlice(' + i + ');" onmouseover="hoverSlice(' + i + ');" onmouseout="blurSlice(' + i + ');" style="color: ' + color + ';"><div class="legend-marker" style="background: ' + color + '"></div>' + row.title + '<div class="legend-value">' + value + ' | ' + percent + '%</div></div>';
  }
});	
	
jQuery(document).ajaxComplete(function() {
    jQuery("a[title='JavaScript charts']").remove();
});	
});
</script>
 
 
 
		
		
		