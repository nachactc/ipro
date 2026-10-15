
<script>
$(document).ready(function() {
	
	$("#tabdata").trigger('click');
	var rTable=popgrid("<?php echo site_url('loi_received/loi_received/dialog_loo')?>","popLoader","trp", 10);
	 
	$('#btloo').click(function() {
		rTable.rows('.selected').deselect();
		$("#tedialog").modal("show");
	});
	$('#btnrek').click(function() { 
		var searchTenant  = $("#searchloo").val(); 
		rTable.search(searchTenant).draw();
	});
	$('#addData').click(function () {

      var linenum=0;
       var rData = rTable.rows('.selected').data();

       for (var i=0; i < rData.length ;i++){
 
          var tloo_id   = rData[i][4];

          $('#loo_id').val(tloo_id);
      }

	}); 
	$.fn.datepicker.defaults.format = "yyyy-mm-dd"; 
    $.fn.datepicker.defaults.autoclose = true; 
}); 
</script> 

<script src="<?php echo base_url('assets/plugins/ckeditorstd/ckeditor.js');?>" type="text/javascript"></script>

<style>

table.dataTable td {
    padding:2px;
    font-size: 9pt;
}

.table td{
    padding:2px;
    font-size: 9pt;
    font-family:  Arial, Verdana, sans-serif;

}

label {
  font-size: 9pt;
}

</style> 
            <!-- CONTENT -->
            <div class="row">
              <div class="col-md-12">
                <div class="portlet">
                  <div class="portlet-title">
                    <div class="caption" align="right">
                      <div class="actions">
                        <div class="btn-group">
                          <a class="btn green dropdown-toggle" href="javascript:;" data-toggle="dropdown"> <i class="fa fa-search"></i> Advanced Search
                          <i class="fa fa-angle-down"></i>
                          </a>
                          <ul class="dropdown-menu pull-right">
                            <br>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="contain">
                                  Author
                                </label>
                                <input class="form-control" type="text" />
                              </div>
                              <div class="form-group">
                                <label for="contain">
                                  Contains the words
                                </label>
                                <input class="form-control" type="text" />
                              </div>
                              <div class="form-group">
                                <label for="contain">
                                  Select Option
                                </label>
                                <select class="form-control">
                                  <option>
                                    Option 1
                                  </option>
                                  <option>
                                    Option 2
                                  </option>
                                  <option>
                                    Option 3
                                  </option>
                                  <option>
                                    Option 4
                                  </option>
                                  <option>
                                    Option 5
                                  </option>
                                </select>
                                <br>
                                <button type="search" class="btn blue">
                                  Search
                                </button>
                              </div>
                            </div>
                          </ul>
                        </div>
                        <div class="btn-group">
                          <a class="btn green dropdown-toggle" href="javascript:;" data-toggle="dropdown"> <i class="fa fa-print"></i> Export
                          <i class="fa fa-angle-down"></i>
                          </a>
                          <ul class="dropdown-menu pull-right">
                            <li>
                              <a href="javascript:;">
                              <i class="fa fa-file-pdf-o"></i> PDF </a>
                            </li>
                            <li>
                              <a href="javascript:;">
                              <i class="fa fa-file-excel-o"></i> EXCEL </a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="tools">
                      <a href="javascript:;" class="collapse"> </a>
                      <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                    </div>
                  </div>
                  <div class="portlet-body">
                    <div class="tabbable-custom ">
                      <ul class="nav nav-tabs ">
                        <li class="active">
                          <a href="<?php echo base_url('index.php/lareport/lalist'); ?>" id='tablist'> LIST </a>
                        </li>
                        <li>
                          <a href="#newdata" data-toggle="tab" id='tabdata'> INPUT </a>
                        </li>
                        <li>
                          <a href="#editdata" id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane" id="newdata">
                          <div class="portlet-body form">
                         <form action="<?php echo site_url('lareport/la_save');?>" method="post" onsubmit="return validateb4submit();">
                   
                    <div class="row">
                      <div class="col-md-12">
                                  <div class="col-md-6 form-group row">
                                    <div class="col-xs-12">
                                      <label>LOO ID</label>
                                      <input  type="text" id="loo_id" name="loo_id" class="form-control input-sm" value="<?php echo $rlooid;?>" readonly>
                                      
                                       <input  type="hidden" id="vloo_id" name="vloo_id" class="form-control input-sm" value="<?php echo $result['loo_id'];?>">
                                    </div>
                                  </div>
                                  
                           
                                  <div class="col-md-6 form-group row">
                                    <div class="col-xs-12">
                                      <label>Ket.Jabatan Point 3.16 (1)</label>
                                      <input  type="text" id="txtdirektur" name="txtdirektur" value="<?php echo $result['direktur'];?>" class="form-control input-sm" >  </div>
                                  </div>
                                 
                                  <div class="col-md-6 form-group row">
                                    <div class="col-xs-12">
                                      <label>Ket.Jabatan Point 3.16 (2)</label>
                                      <input  type="text" id="txtdirektur2" name="txtdirektur2" value="<?php echo $result['direktur2'];?>" class="form-control input-sm" >  </div>
                                  </div>
                                  
                                   <div class="col-md-6 form-group row">
                                    <div class="col-xs-12">
                                      <label>Waktu Fit Out (Hari)</label>
                                      <input  type="text" id="txtfitout" name="txtfitout" value="<?php echo $result['pemberitahuan_ftout'];?>" class="form-control input-sm" >
                                    </div>
                                  </div>
                                  
                                     <div class="col-md-6 form-group row">
                                    <div class="col-xs-12">
                                      <label>Penanggung Jawab</label>
                                      <input  type="text" id="txttggjawab" name="txttggjawab" value="<?php echo $result['penanggung_jawab'];?>" class="form-control input-sm" >
                                    </div>
                                  </div>
                                  
                                   <div class="col-md-6 form-group row">
                                    <div class="col-xs-12">
                                      <label>Jabatan Penanggung Jawab</label>
                                      <input  type="text" id="txtjabatanjawab" name="txtjabatanjawab" value="<?php echo $result['jabatan_pemilik'];?>" class="form-control input-sm" >
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-6 form-group row">
                                    <div class="col-xs-12">
                                      <label>Nama Penandatangan(Penyewa 1)</label>
                                      <input  type="text" id="txtpenyewa" name="txtpenyewa" value="<?php echo $result['penyewa'];?>" class="form-control input-sm" >
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-6 form-group row">
                                    <div class="col-xs-12">
                                      <label>Jabatan Penyewa 1</label>
                                      <input  type="text" id="txtjabatansewa" name="txtjabatansewa" value="<?php echo $result['jabatan_penyewa'];?>" class="form-control input-sm" >
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-6 form-group row">
                                    <div class="col-xs-12">
                                      <label>Nama Penandatangan(Penyewa 2)</label>
                                      <input  type="text" id="txtpenyewa2" name="txtpenyewa2" value="<?php echo $result['penyewa2'];?>" class="form-control input-sm" >
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-6 form-group row">
                                    <div class="col-xs-12">
                                      <label>Jabatan Penyewa 2</label>
                                      <input  type="text" id="txtjabatansewa2" name="txtjabatansewa2" value="<?php echo $result['jabatan_penyewa2'];?>" class="form-control input-sm" >
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-6 form-group row">
                                    <div class="col-xs-12">
                                      <label>Tanggal TTD</label>
                                       <div class="input-group date" data-provide="datepicker">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control input-sm pull-right" id="txtdatettd" name="txtdatettd" value = "<?php echo $result['tgl_sign'];?>">
                                      </div>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-6 form-group row">
                                    <div class="col-xs-12">
                                      <label>Jenis Usaha</label>
                                      <input  type="text" id="txtjenisusaha" name="txtjenisusaha" value="<?php echo $result['jenisusaha'];?>" class="form-control input-sm" >  </div>
                                  </div>
                                 
                                   <div class="col-md-6 form-group row">
                                    <div class="col-xs-12">
                                      <label>Merk Dagang</label>
                                      <input  type="text" id="txtmerkdagang" name="txtmerkdagang" value="<?php echo $result['merkdagang'];?>" class="form-control input-sm" >
                                    </div>
                                  </div>
   
								<div class="col-md-12 form-group row">
                                    <div class="col-xs-12">
                                      <label>Uang Sewa (Point a)</label>
                                      <textarea name="tuangsewa"  style="width: 100%; height: 200px;"><?php echo $result['uangsewa'];?></textarea>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-12 form-group row">
                                    <div class="col-xs-12">
                                      <label>Uang Sewa (Point b)</label>
                                      <textarea name="tuangsewab"  style="width: 100%; height: 200px;"><?php echo $result['uangsewab'];?></textarea>
                                    </div>
                                  </div>
                                  
                                  
                                  <div class="col-md-12 form-group row">
                                    <div class="col-xs-12">
                                      <label>Biaya Pelayanan (point a)</label>
                                      <textarea name="tbiayaservice"  style="width: 100%; height: 200px;"><?php echo $result['uangservice'];?></textarea>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-12 form-group row">
                                    <div class="col-xs-12">
                                      <label>Deskripsi ATM Point II</label>
                                      <textarea name="tdesatm"  style="width: 100%; height: 200px;"><?php echo $result['deskripsiatm'];?></textarea>
                                    </div>
                                  </div>

                                    <!-- /.col -->
                                <div class="col-xs-12">
                                    <br /><input type="submit" value="SUBMIT" name="btsubmit" class="btn btn-sm btn-info" />
                                </div>
                              </div>
                             </div>
                            </form>
                            

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END OF CONTENT -->
			<script>

                CKEDITOR.replace( 'tuangsewa' );
				CKEDITOR.replace( 'tuangsewab' );
				CKEDITOR.replace( 'tbiayaservice' );
				CKEDITOR.replace( 'tdesatm' );
				
           </script>