  <?php 
  $link_id = $this->uri->segment(3);
  $date = date("d-m-Y");
   
 ?>
 
 <link href="<?php echo base_url()."assets/plugins/exportexcel/dist/css/tableexport.css" ?>" rel="stylesheet" type="text/css">
<div align="left" id="buttonExport" style="width:10%;"></div>
<!-- CONTENT -->

              <div > 
                  <div class="portlet-body flip-scroll table-responsive table-scrollable">
                    <table class="table table-hover table-scroll table-bordered table-striped table-condensed flip-content " id="DataReminder_Renewal_<?php echo date('d-m-Y-s') ;?>" >
                      <thead class="flip-content">
                        <tr> 
						  <th >
                            No
                          </th>
						  <th >
                            Business Unit
                          </th>
                          <th width="10%">
                            Property
                          </th>
                          <th width="25%">
                            Tenant
                          </th>
                          <th width="25%">
                            Brand
                          </th>
                          <th width="10%">
                            Tipe
                          </th>
                          <th class="numeric">
                            Agreement
                          </th>
                          <th class="numeric" width="15%">
                            Start Date
                          </th>
                          <th class="numeric" width="15%">
                            End Date
                          </th>
                           
                           
                        </tr>
                      </thead>
                      <tbody>
					    <?php if ($detil_bln) : ?>
						<?php $no= 1;foreach ($detil_bln as $data) : ?>
					  <tr>                        
                        <td><?=$no?></td>
                        <td><?=$data['region_name']?></td>
                        <td><?=$data['branch_name']?></td>
                        <td><?=$data['rekanan_name']?></td>
                        <td><?=$data['rekananshipping_name']?></td>
                        <td><?=$data['rekananshipping_type']?></td>
                        <td><?=$data['agreement_id']?></td> 					   
                        <td><?=date("d-M-Y",strtotime($data['agreement_startperiod']))?></td>
                        <td><?=date("d-M-Y",strtotime($data['agreement_endperiod']))?></td>
					   </tr> 
                        <?php $no++;endforeach; ?> 
                         <?php else: ?>
						<div class="alert alert-success fade in ">
						  <a href="#" class="close" data-dismiss="alert" aria-label="close" style="width:20px;height:20px; background-color: #F00; background: #000;">x</a>
						  <strong>Info!</strong> Belum Ada Data!
						</div>
				        <?php endif; ?> 
                      </tbody>
                    </table>
                  </div>
                
                <!-- END SAMPLE TABLE PORTLET-->
                
              </div>
            </div>
<script src="<?php echo base_url('assets/plugins/jquery.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/scripts/layout.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/plugins/exportexcel/" ?>xls.core.js"></script>
<script src="<?php echo base_url()."assets/plugins/exportexcel/" ?>Blob.js"></script>
<script src="<?php echo base_url()."assets/plugins/exportexcel/" ?>FileSaver.js"></script>

<script src="<?php echo base_url()."assets/plugins/exportexcel/dist/js/tableexport.js" ?>"></script>
<script>
 
 $("table").tableExport({
	 headings: true,                    // (Boolean), display table headings (th/td elements) in the <thead>
    footers: true,                     // (Boolean), display table footers (th/td elements) in the <tfoot>
	 bootstrap: true,
	 position: "left-top", 
	 formats: ["xlsx"], 
	 fileName: "id", 
	 ignoreRows: null,                  // (Number, Number[]), row indices to exclude from the exported file(s)
    ignoreCols: null,                  // (Number, Number[]), column indices to exclude from the exported file(s)
    ignoreCSS: ".tableexport-ignore",  // (selector, selector[]), selector(s) to exclude from the exported file(s)
    emptyCSS: ".tableexport-empty",    // (selector, selector[]), selector(s) to replace cells with an empty string in the exported file(s)
    trimWhitespace: true              // (Boolean), remove all leading/trailing newlines, spaces, and tabs from cell text in the exported file(s)
	 });
	 
	
/**

	/* Excel Binary spreadsheet (.xls) */
	$.fn.tableExport.xls = {
		defaultClass: "xls",
		buttonContent: "Export to xls",
		separator: "\t",
		mimeType: "application/vnd.ms-excel",
		fileExtension: ".xls"
	};
	/* Excel Open XML spreadsheet (.xlsx) */
	$.fn.tableExport.xlsx = {
		defaultClass: "xlsx",
		buttonContent: "Export to xlsx",
		mimeType: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
		fileExtension: ".xlsx"
	}; 

	 var $buttons =  $("table").find('caption').children().detach();
	// Append the buttons to an element of your choosing
	$buttons.appendTo('#buttonExport');


</script>			 