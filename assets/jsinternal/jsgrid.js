function listgrid(vlink,namatable,optsearch, pLength=10, aCenter=[]){
	
	var selected = [];
		$('#'+namatable+' tbody').on( 'click', 'tr', function () {
	    	$(this).toggleClass('selected');
		} );
		
	var oTable=$('#'+namatable).DataTable({
		"scrollY": "300px",
        "scrollX": true,
        "scrollCollapse": true,        
		"pageLength": pLength,
		"processing": true, 
		"serverSide": true, 
		"order": [],
		"searching" : true,
		"ajax": {
			"url": vlink,
			"type": "POST"	
		},
		"rowCallback": function( row, data ) {
	            if ( $.inArray(data.DT_RowId, selected) !== -1 ) {
	                $(row).addClass('selected');
	            }
		},
		"columnDefs": [
		{
		"targets": [ -1 ], //last column
		"orderable": false, //set not orderable
		},
		 {
	      "targets": aCenter,
	      "className": "text-center",
		 }
		],
		dom:optsearch
		});

	return oTable;
}

function popgrid(vlink,namatable,optsearch, pLength=10, aCenter=[]){
	
	var selected = [];
		$('#'+namatable+' tbody').on( 'click', 'tr', function () {
	    	$(this).toggleClass('selected');
		} );
		
	var oTable=$('#'+namatable).DataTable({		     
		"pageLength": pLength,
		"processing": true, 
		"serverSide": true, 
		"order": [],
		"searching" : true,
		"ajax": {
			"url": vlink,
			"type": "POST"	
		},
		"rowCallback": function( row, data ) {
	            if ( $.inArray(data.DT_RowId, selected) !== -1 ) {
	                $(row).addClass('selected');
	            }
		},
		"columnDefs": [
		{
		"targets": [ -1 ], //last column
		"orderable": false, //set not orderable
		},
		 {
	      "targets": aCenter,
	      "className": "text-center",
		 }
		],
		dom:optsearch
		});
			
	return oTable;
}

function searchgrid(vlink,namatable,optsearch, pLength=10, aCenter=[], object_1, object_2){
	
	var selected = [];
		$('#'+namatable+' tbody').on( 'click', 'tr', function () {
	    	$(this).toggleClass('selected');
		} );
		
	var oTable=$('#'+namatable).DataTable({		
		"pageLength": pLength,
		"processing": true, 
		"serverSide": true, 
		"order": [],
		"searching" : true,
		"ajax": {
			"url": vlink,
			"type": "POST",
			"data": function(d){
				d.f_date = object_1.val();
				d.t_date = object_2.val();				
			}
		},
		"rowCallback": function( row, data ) {
	            if ( $.inArray(data.DT_RowId, selected) !== -1 ) {
	                $(row).addClass('selected');	                	
	            }
		},
		"columnDefs": [
		{
		"targets": [ -1 ], //last column
		"orderable": false, //set not orderable
		},
		 {
	      "targets": aCenter,
	      "className": "text-center",
		 }
		],
		dom:optsearch
		});

	return oTable;
}

function checkgrid(vlink,namatable,optsearch, pLength=10, aCenter=[], object_1, object_2){	
		
	var oTable=$('#'+namatable).DataTable({		
		"pageLength": pLength,
		"processing": true, 
		"serverSide": true, 
		"order": [],
		"searching" : true,
		"ajax": {
			"url": vlink,
			"type": "POST",
			"data": function(d){
				d.f_date = object_1.val();
				d.t_date = object_2.val();				
			}
		},		
		"columnDefs": [
		{ "targets": [ -1 ], "orderable": false },
		{ "targets": aCenter, "className": "text-center"},
		{ orderable: false, className: 'select-checkbox', targets:   0 }		
		],
		select: { style: 'os', selector: 'td:first-child' },
		dom:optsearch
	});

	return oTable;
}

function foogrid(vlink,namatable,optsearch, hide=[], pLength=10){
	
	var selected = [];
		$('#'+namatable+' tbody').on( 'click', 'tr', function () {
	    	$(this).toggleClass('selected');
		} );
		
	var oTable=$('#'+namatable).DataTable({ 		
		"pageLength": pLength, 
		"order": [],	
		"rowCallback": function( row, data ) {
	            if ( $.inArray(data.DT_RowId, selected) !== -1 ) {
	                $(row).addClass('selected');
	            }
		},
		"columnDefs": [
			{ "targets": [ -1 ], "orderable": false },
			{ "targets": hide, "visible": false }
		],
		dom:optsearch		
		});

	return oTable;
}

function GetDgvLineMaxNum(objDgv, colnum) {
			var table = $('#'+objDgv+' tbody');
            var max = 0;
            var value = 0;            

           table.find('tr').each(function (i) {
               var $tds = $(this).find('td'),               
               value = $tds.eq(colnum).text();

    
               if (max < value) {
                max = parseInt(value);
              } 
              
            } );           

            return max;
} 