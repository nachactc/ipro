 

<!-- <div align="left" id="buttonExport" style="width:auto;"></div> 
<link href="<?php //echo base_url('assets/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css');?> " rel="stylesheet" type="text/css" />   
<link href="<?php// echo base_url()."assets/css/" ?>jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php //echo base_url()."assets/css/" ?>buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
 -->  
 
<link href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css');?> " rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('assets/plugins/jquery.min.js');?>" type="text/javascript"></script> 
<script src="<?php echo base_url()."assets/plugins/exportexcel/table2excel/" ?>jquery.table2excel.js"></script> 
<button class="exportToExcel noExl">Export to EXCEL</button> 
<br><br> 
<br><br> 

 <title> Report <?php echo $title; ?> </title>
 
 <html>
 <body>
<?php  if($result != 'kosong'){ 
		$template = array(
				'table_open'            => '<table border="0" cellpadding="4" cellspacing="0" class="table table-sm table2excel" id="DGV" style="width: 100%">',

				'thead_open'            => '<thead class="thead-dark">',
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
		echo $this->table->generate($result);

 } else { echo "Data Aging Kosong"; }  ?>

</body>
<script src="<?php echo base_url().'assets/plugins/jquery.min.js';?>" type="text/javascript"></script> 
<!--<script src="<?php //echo base_url().'assets/plugins/datatables/datatables.min.js';?>" type="text/javascript"></script>  
<script src="<?php //echo base_url().'assets/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js';?>" type="text/javascript"></script>    
<script src="<?php //echo base_url()."assets/scripts/datatable.js" ?>" type="text/javascript"></script>  
--> 
<script src="<?php echo base_url()."assets/plugins/exportexcel/table2excel/" ?>jquery.table2excel.js"></script> 
<script>  
			
  $(document).ready(function(){
	  
	// $('#DGV').dataTable( {
    // "iDisplayLength": 100, 
        // "scrollX": true, 
		 // dom: 'Bfrtip',
        // buttons: [
             // 'excel',  'print'
        // ],
  // } );
	  $(".exportToExcel").click(function(e){ 
					$(".table2excel").table2excel({
						exclude: ".noExl", 
						name: "Rpt_AgingV3",
						filename: "Rpt_AgingRAW_" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
						preserveColors: false // set to true if you want background colors and font colors preserved
					}); 
				});
				
	  });
</script> 
</html>