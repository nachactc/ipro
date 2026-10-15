<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

		if ($this->uri->segment(3)=="" || $this->uri->segment(3)=="load"){
?>
<!-- komponen tambahan untuk dialog konfirm-->
<script src="<?php echo base_url('/assets/js/bootbox/bootbox.min.js');?>"></script>


<script>  

$(document).ready(function(){
	/** Start Delete **/
	$("#JTable").on('click','#btnDelete',function(){
		// Delete id
		var deleteid = $(this).data('id');
		var deleteln = $(this).data('ln');
		// Confirm box
		bootbox.confirm(
		{
			message: "Do you really want to delete a record "+deleteid+" ?",
			buttons:
			{
				confirm:
				{
					label: 'Yes',
					className: 'btn btn-sm btn-primary waves-effect waves-themed'
				},
				cancel:
				{
					label: 'No',
					className: 'btn btn-sm btn-danger waves-effect waves-themed'
				}
			},
			callback: function(result)
			{ 
				if(result){
					// AJAX Request
					$.ajax({
						url: "<?php echo base_url('index.php/').$this->uri->segment(1).'/'.$this->uri->segment(2).'/trx_delete'; ?>",
						dataType: 'json',
						type: "POST",
						delay: 250,
						data: { strukturunit_id:deleteid,strukturunitapprovalauth_line:deleteln },
						success: function(response){ 
							if(response == 1){
								alert('Data telah di Hapus');
								var url = "<?php echo base_url('index.php/').$this->uri->segment(1).'/'.$this->uri->segment(2).'/load';?>";
								$(location).attr('href',url);
							}
							else
							{
								alert(response);
								var url = "<?php echo base_url('index.php/').$this->uri->segment(1).'/'.$this->uri->segment(2).'/load';?>";
								$(location).attr('href',url);
							}
						}
					});
				}
			}
		});
	});
	/** End Delete **/
	
	$('#JTable').DataTable({
      "scrollY": "400px",
      "scrollX": true,       
      "pageLength": 20,
      "processing": true, 
      "serverSide": true, 
      "order": [],
      "searching" : true,
	  "ordering": false, 
	  "bLengthChange": false,
		<?php 
		if ($_POST){
		?>
		"ajax": {
			"url": "<?php echo base_url('index.php/').$this->uri->segment(1).'/'.$this->uri->segment(2).'/controler_gridlist'; ?>",
			"type": "POST",
			"data": { 
				jurnal_id :  "<?php echo $this->input->post("sID");?>",
				jurnal_source :  "<?php echo $this->input->post("jSource");?>",
				jurnaltype_id :  "<?php echo $this->input->post("jType");?>",
				periode_id :  "<?php echo $this->input->post("sPeriode");?>",
				jurnal_createby :  "<?php echo $this->input->post("sCreateby");?>",
			},
			"dataType": 'json'
		},	
		<?php
		}else{
		?>
		"ajax": {
			"url": "<?php echo base_url('index.php/').$this->uri->segment(1).'/'.$this->uri->segment(2).'/controler_gridlist'; ?>",
			"type": "POST"  
		},
		<?php	
		}
		?>	
	
      "columnDefs": [
        {
          "targets": [ -1 ], //last column
          "orderable": false, //set not orderable
        },
        // {
          // "targets": aCenter,
          // "className": "text-center"
        // },
        // {
          // "targets": aRight,
          // "className": "text-right"
        // }        
      ], 
	  // dom:'rtip'
      });
	  
    //new $.fn.dataTable.FixedColumns( oTable, { rightColumns: 1 } );
  	$('#tabedit').click(function() {
  		alert('Please, select data from list');
  		$("#tablist").trigger('click');
  	});
		
	$('.searching').select2();
	
	/* reload */
    $('#btnReload').click(function() {  
	console.log('searching');
        
	
	});
	
	$('#isID').on('change', function() {      
        if($(this).is(':checked')){
          $('#sID').prop('readonly', false);          
		  }else{      
          $('#sID').prop('readonly',true);          
        }
    }); 

    $('#isCreate').on('change', function() {      
        if($(this).is(':checked')){
          $('#sCreateby').prop('readonly', false);          
        }else{      
          $('#sCreateby').prop('readonly',true);          
        }
    });  

    $('#isPeriod').on('change', function() {      
        if($(this).is(':checked')){
          $('#sPeriode').prop('readonly', false);          
        }else{      
          $('#sPeriode').prop('readonly',true);          
        }
    });

    $('#isJtype').on('change', function() {      
        if($(this).is(':checked')){
          $('#jSource').prop('disabled', false);          
        }else{      
          $('#jSource').prop('disabled',true);          
        }
    });

    $('#jSource').val([]);
    $('#jSource').select2({placeholder: 'Select an Option'});
    $('#jSource').on('select2:select', function (e) {
        var source  = e.params.data;
        var jtype   = source.id.substring(0,2);
        //console.log(jtype);

        $('#isTSource').prop( "checked", true );
        $('#tSource').val( source.id );
        $('#jType').val(jtype);
        //$('#_hTradeLine').val(bra.rekananshipping_line);
    });
}); 
</script>
<?php
		} 
		if ($this->uri->segment(3)=="add" || $this->uri->segment(3)=="edit"){
?>
<script src="<?php echo base_url('/assets/js/inputmask/inputmask.bundle.js');?>"></script>
<script src="<?php echo base_url('/assets/js/jquery.number.min.js');?>"></script>
<script src="<?php echo base_url('/assets/js/jquery.maskedinput.min.js');?>"></script>
<script> 
 
	$(document).ready(function(){
		$.fn.modal.Constructor.prototype.enforceFocus = function () {}; 
		$.fn.select2.defaults.set( "theme", "bootstrap" );
		// $("#dt-basic-debet").hide();
		
		<?php if($this->uri->segment(3) == 'edit' ) { ?> 
		$("#tabedit").trigger('click');	 
		<?php }
		elseif($this->uri->segment(3)=="add")
		{
		?> 
		$("#tabdata").trigger('click');  
		<?php } ?> 
		$("#istruk").select2();   
		$("#iuser").select2();   
	});
	 
</script>
<?php
		}
?>