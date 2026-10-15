<link href="<?php echo base_url('assets/plugins/morris/morris.css'); ?>" rel="stylesheet" type="text/css" />  
<link href="<?php echo base_url('assets/css/plugins.min.css'); ?>" rel="stylesheet" type="text/css" />  
<link href="<?php echo base_url('assets/css/custom.min.css'); ?>" rel="stylesheet" type="text/css" />     

<style> 
body {
    opacity: 1;
    transition: 1s opacity;
}
body.fade-out {
    opacity: 0;
    transition: none;
}
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

.modal-header {
    background-color: white;
}

.alert {
    padding: 15px;
}

.table thead tr th {
    font-size: 9pt;
}
.table th, .table td{
    padding:2px;
    font-size: 9pt;
    white-space: nowrap;
}


  /* Gaya untuk kontainer tabel dengan scroll */
  .table-container {
    max-height: 300px; /* Batas tinggi kontainer */
    overflow-y: auto; /* Scroll vertikal */
    border: 1px solid #ddd; /* Border untuk kontainer */
    position: relative;
  }

  /* Gaya untuk membuat header tetap terlihat saat scroll */
  thead {
    position: sticky;
    top: 0;
    background-color: #f1f1f1;
    z-index: 2; /* Pastikan header tetap di atas */
  }

  /* Mengatur posisi relatif untuk kolom header */
  th {
    position: -webkit-sticky; /* Untuk Safari */
    position: sticky;
    top: 0;
    background-color: #f1f1f1;
  }

</style>	

<script>
    document.body.className += ' fade-out';
</script>			



  <!-- /.Warning PopUp -->
  <div class="modal" id="renewal_dlg" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <div class="alert alert-danger" style="display: flex; justify-content: space-between;">
                <div>
                    <strong>Warning!</strong> There are <?=$reminder_12bln?> items in the list that need renewal.
                </div>
                <div class="icon">
                    <i class="font-red-haze glyphicon glyphicon-warning-sign blink">
                    </i>
                </div>
            </div>
        </div>
        <div class="modal-body">

            <div class="portlet-body">
              <div class="table-container">
                <!--<div class="table-scrollable">-->
                  <table class="table table-striped table-bordered compact nowrap" id='renewalTbl' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
                    <thead>
                      <tr>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">No.</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Agreement</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Start Date</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">End Date</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Store</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tenant</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Brand</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tipe</th>
                      </tr>
                    </thead>
                    <tbody>					  
                        <?php $no= 1;foreach ($detil_bln as $data) : ?>
					  <tr> 					   
					   <td><?=$no?></td>								   
					   <td><?=$data['agreement_id']?></td> 					   
					   <td><?=date("d-M-Y",strtotime($data['agreement_startperiod']))?></td>
					   <td><?=date("d-M-Y",strtotime($data['agreement_endperiod']))?></td>
					   <td><?=$data['branch_name']; ?></td>
					   <td><?=$data['rekanan_name']; ?></td>
					   <td><?=$data['rekananshipping_name']; ?></td>
					   <td><?=$data['rekananshipping_type']; ?></td>					   
					   </tr> 
                        <?php $no++;endforeach; ?>
                    </tbody>
                  </table>
                <!--</div>-->
              </div>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn blue btn-outline" href="<?=$link_12bln?>" target="_blank">Open List <i class="icon-arrow-right"></i>
            </a> 
            <button type="button" class="btn dark btn-outline" data-dismiss="modal">
                Close
            </button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
			

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
                      <span style="width: 0%;" class="progress-bar progress-bar-success purple-soft">
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
			  <?php echo date('d-M-Y') ; ?>
			  </span>
			  <span> &nbsp; </span>
			</div>
			<div class="row">
              <div class="col-md-3">
                <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                  <h4 class="widget-thumb-heading">
                   Proforma Outstanding 
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
                   Proforma Outstanding Payment
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
                    Proforma
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
                  Payment Proforma Invoice 
                  </h4>
                  <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-blue icon-bar-chart">
                    </i>
                    <div class="widget-thumb-body">
                      <span class="widget-thumb-subtitle">
                        IDR 
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
			<!--<div class="col-md-6" align="center">
				<div class="sparkline-chart"> <a class="title" href="javascript:;"> Invoice 
				<?php //echo date('M').'-'.date('Y'); ?> 
				  </a>
				 <div id="chartdivInv" align="center" style="width: 385px; height: 200px;"></div> 
				</div>
			</div>-->
			<!-- grafik-->
			</div>
			 
			
			 
				
				<div class="row">
				<div class="col-md-3">
                <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                  <h4 class="widget-thumb-heading">
                   Brand Tenant (Master)
                  </h4>
                  <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-blue icon-bar-chart">
                    </i>
                    <div class="widget-thumb-body">
                      <span class="widget-thumb-subtitle">
                        TOTAL
                      </span>
					  <small>
                      <span style="font-size:15px;"  class="widget-thumb-body-stat" data-counter="counterup" data-value="<?php echo ($tenant_jml); ?>">
                        0
                      </span>
					  </small>
                    </div>
                  </div>
                </div>
              </div>
             
				<div class="col-md-3">
                <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                  <h4 class="widget-thumb-heading">
                  Brand Tenant (Agreement)
                  </h4>
                  <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-blue icon-bar-chart">
                    </i>
                    <div class="widget-thumb-body">
                      <span class="widget-thumb-subtitle">
                        TOTAL
                      </span>
					  <small>
                      <span style="font-size:15px;"  class="widget-thumb-body-stat" data-counter="counterup" data-value="<?php echo ($brand_jml); ?>">
                        0
                      </span>
					  </small>
                    </div>
                  </div>
                </div>
              </div>
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
				 
                  <div class="portlet-body">
				  <span class="caption-subject font-dark bold uppercase">
                    
                   </span>
                    <div class="row" align="right">
					
					 <div id="chartdivTenant" align="right" ></div> 
					 <div id="legend"  align="right"></div>
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
                   Trans Cibubur Property ( TCP ) ( Total : <?php echo $dataLooAll_trp; ?> LOO)
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
    $(function() {
        $('body').removeClass('fade-out');
    });

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
            "graphs": [{
                "valueField": "total",
                "type": "column",
                "fillAlphas": 0.8,
                "angle": 30,
                "depth3D": 15,
                "balloonText": "[[category]]: Total Posting <b>[[value]]</b>"
            }] 
        });

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

        $(window).load(function() {    

            $("#renewal_dlg").modal("show");
        });

    });
</script>
 
 
 
		
		
		