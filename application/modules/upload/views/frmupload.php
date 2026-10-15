 <script>
        $(document).ready(function(){
          $("#tabedit").trigger('click');
		   });
		   </script>
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
                          <a href="<?php echo base_url('index.php/upload/uploaddoc/uploadlist'); ?>" id='tablist'> LIST </a>
                        </li>
                        <li>
                          <a href="#editdata" data-toggle="tab" id='tabedit'> UPLOAD </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        
                        <div class="tab-pane" id="editdata">
                          <div class="portlet-body form">
                            <div class="message_box">
            <?php
            if (isset($success) && strlen($success)) {
                echo '<div class="success">';
                echo '<p>' . $success . '</p>';
                echo '</div>';
            }
 
            if (isset($errors) && strlen($errors)) {
                echo '<div class="error">';
                echo '<p>' . $errors . '</p>';
                echo '</div>';
            }
 
            if (validation_errors()) {
                echo validation_errors('<div class="error">', '</div>');
            }
            ?>
        </div>
        
                         <form action="<?php echo site_url('upload/uploaddoc/actupload');?>" method="post" enctype="multipart/form-data">
                            <?php 
                    if(isset($result)){
                     //print_r($result);
                     foreach($result as $row){ ?>                                   
                    <div class="row">
                        <div class="col-md-12">   
                                <div class="col-md-4 form-group row">                               
                                  <div class="col-xs-12">
                                      <label>ID</label>
                                    <input  type="text" id="looid" name="loo_id" class="form-control input-sm" value="<?php echo $row->loo_id;?>" readonly /><input type="hidden" value="<?php echo $loo_id;?>" name="loo_id"  /><input type="hidden" value="<?php echo $tipe;?>" name="tipe"  />
                                  </div> 
                                </div>                                    
                                  <!-- /.form group -->   
                                 
                                                      
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Business Unit</label>
                                    <?php echo form_dropdown('cboregion',$region,$row->region_id,'id ="iregion" class="form-control" style="width: 100%;" required'); ?>
                                  </div>
                                </div>
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Store</label>
                                      <select data-placeholder="Select a store" id= "ibranch" name= "cbobranch" required class="form-control">
                                        <option value="<?php echo $row->branch_id;?>" selected="selected" ><?php echo $row->branch_name;?></option>
                                      </select>
                                    </div> 
                                  </div>
<div class="row"></div>
							<div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                      <label>Agreement ID</label>
                                      <input type="text" value="<?php echo $agid;?>" name="agid" readonly class="form-control input-sm"  />
                                      <input type="hidden" id = "hbrand" name="hbrand" value="<?php echo $row->rekananshipping_line;?>">
                                  </div>
                                </div>
                                
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <a href="javascript:void(0)" id="bttenant"><strong>Tenant:</strong></a>                                  
                                    <input type="text" id = "itenant" required name="itenant" class="form-control input-sm" value="<?php echo $row->rekanan_name;?>" required autocomplete="off">
                                    <input type="hidden" id = "htenant" name="htenant" value="<?php echo $row->rekanan_id;?>">
                                  </div>
                                </div>
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                      <label></label>
                                      <input type="text" id = "ibrand" name="ibrand" class="form-control input-sm" value="<?php echo $row->rekananshipping_name;?>" required autocomplete="off">
                                      <input type="hidden" id = "hbrand" name="hbrand" value="<?php echo $row->rekananshipping_line;?>">
                                  </div>
                                </div>
 

                                <?php }}?>
                                <div class="row"></div>
                       
        <div class="col-md-4 form-group row">
           <div class="col-xs-12">

            <fieldset>
                <section>
                    <table>
                    <tr><td>Browse a file</td>
                    <td>Description</td><td>&nbsp;</td></tr>
                    <tr><td><input type="file" name="upload_file1" id="upload_file1" readonly="true"/></td>
                    <td><input type="text" name="tdes1" id="tdes1"/></td><td>&nbsp;</td></tr></table>
                 
                    <div id="moreImageUpload"></div>
                    <div style="clear:both;"></div>
                    <div id="moreImageUploadLink" style="display:none;">
                        <a href="javascript:void(0);" id="attachMore">Attach another file</a>
                    </div>
                </section>
            </fieldset>
            <br>

                <input type="submit" name="btupload" value="Upload" class="btn btn-primary"/>


            </div>
       </div>

<div class="row"></div>
                       
        <div class="col-md-12 form-group row">
           <div class="col-xs-12">
            <table class="table table-striped table-bordered table-hover compact nowrap" id='popLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
                                  <thead>
                                   <tr>
                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">File Name</th>
                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Description</th>
                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">View</th>
                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Delete</th>
                                   </tr>
                                  </thead>
                                  <tbody>
                                  <?php 
                    if(isset($rupload)){
                     //print_r($result);
                     foreach($rupload as $rowx){ 
					 $i_link = str_replace('/', '_', $rowx->loo_id);
					 $link="assets/uploads/".$rowx->agrrement_id."/".$rowx->nama_file;
					 $link2="/index.php/upload/uploaddoc/delupload/".$i_link."/".$rowx->agrrement_id."/".$rowx->nama_file."/".$rowx->tipe;
					 ?>  
                     <tr>
                     <td><?php echo $rowx->nama_file;?></td>
                     <td><?php echo $rowx->description;?></td>
                     <td><a href="<?php echo base_url($link); ?>" target="_blank">View</a></td>
                     <td><a href="<?php echo base_url($link2); ?>" target="_blank">Delete</a></td>
                     </tr>
                     
                     <?php }}?>
                                  </tbody>
                                </table>
           </div>
           </div>

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              </form>
              <!-- END OF CONTENT -->

        
        
        <script type="text/javascript">
    $(document).ready(function() {
        $("input[id^='upload_file']").each(function() {
            var id = parseInt(this.id.replace("upload_file", ""));
            $("#upload_file" + id).change(function() {
                if ($("#upload_file" + id).val() !== "") {
                    $("#moreImageUploadLink").show();
                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var upload_number = 2;
        $('#attachMore').click(function() {
            //add more file
            var moreUploadTag = '';
            moreUploadTag += '<div class="element">';
            moreUploadTag += '<table><tr><td><input type="file" id="upload_file' + upload_number + '" name="upload_file' + upload_number + '"/></td><td><input type="text"  id="tdes' + upload_number + '" name="tdes' + upload_number + '"/></td>';
            moreUploadTag += '<td>&nbsp;<a href="javascript:del_file(' + upload_number + ')" style="cursor:pointer;" onclick="return confirm("Are you really want to delete ?")">Cancel</a></td></table></div>';
            $('<div id="delete_file' + upload_number + '">' + moreUploadTag + '</div>').fadeIn('slow').appendTo('#moreImageUpload');
            upload_number++;
        });
    });
</script>

<script type="text/javascript">
    function del_file(eleId) {
        var ele = document.getElementById("delete_file" + eleId);
        ele.parentNode.removeChild(ele);
    }
</script>
