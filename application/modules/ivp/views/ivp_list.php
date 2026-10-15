 
<style>
table.dataTable td {
    padding:2px;
    font-size: 9pt;    
}

</style>
      <!-- CONTENT -->            
      <!--<?php //echo form_open('ivp/report_load',"target='_blank' id='FormE'"); ?>-->
		  <!-- 1 --> 
		  <div class="row"> 
		    <div class="col-md-12">					                    
				  <div class="col-md-4 form-group">
            <label for="contain">
              <b>End Date</b>
            </label>
            <div class="input-group input-group-sm">
              <input class="form-control tanggal" type="text" id="t_date" name="enddate" autocomplete="off" value='<?php echo date("Y-m-d");?>' required/>
              <span class="input-group-btn">
                <button id ="btcleart_2" type="button" class="btn btn-primary"><i class="fa fa-eraser"></i></button>                
              </span>
            </div>
          </div>
          <div class="col-md-4 form-group "> 
            <br>
            <button type="button" class="btn btn-sm blue-madison" id="bGenerate">
              <span class="spinner-border spinner-border-sm mr-3" id="spinner" role="status"></span>
              GENERATE 
            </button>
          </div>
        </div>
      </div>							  
      <!--<?php //echo form_close(); ?>      -->
		  <!-- 1 -->
        <!-- END OF CONTENT -->
  
<script> 
$.fn.datepicker.defaults.format = "yyyy-mm-dd";
$.fn.datepicker.defaults.autoclose = true;

$(document).ready(function(){ 
 
	$('.tanggal').datepicker();	

	$('#btcleart_2').click(function() {    

	$('#t_date').val('');     

	});  

  $('#bGenerate').on('click', async function(){
    
    let enddate = $('#t_date').val();
    let param ={}

    param['enddate'] = enddate;

    $.blockUI({message: 'Generating Report, Please Wait...'});

    try {

        let result = await ajaxRequest('<?php echo site_url("ivp/report_result");?>', param);

        if (!result.status){
          alert(result.message);
        } else {

          $.unblockUI();

          $.blockUI({message: 'Exporting to Excel...'});

          //let result = await ajaxRequest('<?php //echo site_url("ivp/export_result");?>', param);
          let result = await ajaxRequest('<?php echo site_url("ivp/export_csv");?>', param);

          //let fileName = `Invoice_vs_Payment-on-`+enddate+`.xlsx`;
          let fileName = `Invoice_vs_Payment-on-`+enddate+`.csv`;
          const mimeType = 'application/vnd.ms-excel';
          let bytesBase64 = result.file;

          let fileUrl = "data:" + mimeType + ";base64," + bytesBase64;

          let $a = $("<a>");
          $a.attr("href", fileUrl);
          $a.attr("download", fileName);          
          $("body").append($a);
          $a[0].click();
          $a.remove();

        }

        $.unblockUI();

    } catch (err) {
      console.error(err);
    }

  });

  async function ajaxRequest(url, param) {
      let result;

      try {
           result = await $.ajax({
               url: url,
               type: 'POST',
               data: param,
               dataType: 'json'
           });
           return result;

      } catch (error) {
        console.error(error);
      }
  }  

  function getExcel(url, param){

    let rptDate = param.enddate;

    $.ajax({
        url: url,
        destroy: true,
        type: 'POST',
        data: param,
        dataType:'json',
        beforeSend: function(){
          $.blockUI({message: 'Exporting to Excel...'});
        },         
        success: function(res) {
          //window.open(url, '_blank');
          //let blob = this.dataURItoBlob(THE_MIME_TYPE + "," + res.file);
			    let fileName = `Invoice_vs_Payment-on-` + rptDate + `.xlsx`;
			   const mimeType = 'application/vnd.ms-excel';
          	const bytesBase64 = res.file;

          	let fileUrl = "data:" + mimeType + ";base64," + bytesBase64;

/*
          window.saveFile = function (bytesBase64, mimeType, fileName) {
          var fileUrl = "data:" + mimeType + ";base64," + bytesBase64;
          fetch(fileUrl)
              .then(response => response.blob())
              .then(blob => {
                  var link = window.document.createElement("a");
                  link.href = window.URL.createObjectURL(blob, { type: mimeType });
                  link.download = fileName;
                  document.body.appendChild(link);
                  link.click();
                  document.body.removeChild(link);
              });
          }
*/

/*
          var blob = b64toBlob(res.file);
          var blobUrl = URL.createObjectURL(blob);

          let link = document.createElement("a");
          link.download = `Invoice_vs_Payment-on-`+rptDate+`.xlsx`;
          link.href = uri;
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
*/
        
          /*
          let blob = await fetch(fileUrl).blob(); 
          let uri = URL.createObjectURL(blob);

          var $a = $("<a>");          
          $a.attr("href", uri);
          $a.attr("download", `Invoice_vs_Payment-on-`+rptDate+`.xlsx`);          
          $("body").append($a);
          $a[0].click();
          $a.remove();
          */
          /*
          let link = document.createElement("a");
          link.download = `Invoice_vs_Payment-on-`+rptDate+`.xlsx`;
          link.href = uri;
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);

          */
          
          
          //console.log(res);
          
          var $a = $("<a>");
          $a.attr("href", fileUrl);
          $a.attr("download", `Invoice_vs_Payment-on-`+rptDate+`.xlsx`);          
          $("body").append($a);
          $a[0].click();
          $a.remove();
          

        },
        error: function(){
          alert('error when get data');
        },
        complete: function() {
          $.unblockUI();
        }
    });

  }  
	
});

</script>
