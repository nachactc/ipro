function listgrid(vlink,namatable,optsearch){
var selected = [];
	$('#'+namatable+' tbody').on( 'click', 'tr', function () {
    	$(this).toggleClass('selected');
	} );
	
var oTable=$('#'+namatable).DataTable({ 
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
	],dom:optsearch 
	
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
                max = value;
              } 
                                                
            } );           

            return max;
        } 