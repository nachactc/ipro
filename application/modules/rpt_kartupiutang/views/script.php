
<script src="<?php echo base_url('assets/js/clipboard.js/dist/clipboard.min.js');?>" type="text/javascript"></script>  
<script src="<?php echo base_url('assets/js/datatables.export.js');?>" type="text/javascript"></script> 

<script> 
 $(function() {
		$(".menu-toggler").trigger('click');
		$("#excel").click(function(e){ 
			
		});
		
		$(".exportToExcel").click(function(e){ 
		var clipboard = new ClipboardJS('.btn');

			clipboard.on('success', function(e) {
			  console.info('Action:', e.action);
			  console.info('Text:', e.text);
			  console.info('Trigger:', e.trigger); 
			  alert('Data Telah dicopy!');
			  e.clearSelection();
			});

			clipboard.on('error', function(e) {
			  console.error('Action:', e.action);
			  console.error('Trigger:', e.trigger);
			});
		}); 
		$("#reports_table").dataTable().fnDestroy(); 	
		$("#reports_table").dataTable({
		  "scrollY": "380px",
		  "scrollX": true,       
		  "pageLength": -1,
		  "processing": false, 
		  "serverSide": false,  
		  "searching" : true,
		  "ordering": false, 
		  "bLengthChange": false,
		  "orderable": false, 
		  deferRender: true,
		  dom: 'Bfrtip',
		  buttons: [  
						
						{
							extend: 'copyHtml5',
							text: 'Copy',
							titleAttr: 'Copy to clipboard',
							className: 'btn-primary btn-sm md-1'
						},
						{
							extend: 'excelHtml5',
							text: 'Excel',
							titleAttr: 'Generate Excel',
							className: 'btn-success btn-sm md-1'
						}, 
					]
		});
		
});
</script> 