  <?php 
 header("Content-type: application/vnd-ms-excel");
 
 header("Content-Disposition: attachment; filename=$title.xls");
 
 header("Pragma: no-cache");
 
 header("Expires: 0");
 
 ?>
                    <table class="table table-hover table-scroll table-bordered table-striped table-condensed flip-content " >
                      <thead class="flip-content">
                        <tr> 
						  <th width="60%">
                            Tipe
                          </th>
                          <th width="60%">
                            Tenant
                          </th>
                          <th class="numeric">
                            Level
                          </th>
                          <th class="numeric" width="70%">
                            Area (M2) OCC   
                          </th>
                          <th class="numeric">
                             Area (M2) VAC  
                          </th>
                          <th class="numeric">
                            Rental	(Rp)
                          </th>
                          <th class="numeric">
                            Service Charge (Rp)
                          </th>
                          <th class="numeric">
                            Masa Sewa (Bulan)
                          </th>
                          <th class="numeric">
                            Periode Sewa RCD
                          </th>
                          <th class="numeric">
                            Periode Sewa LED
                          </th>
                          <th class="numeric">
                            LOI Process
                          </th>
                          <th class="numeric">
                            LOI Sent
                          </th>
                          <th class="numeric">
                            LOI Received
                          </th>
                          <th class="numeric">
                            LOI Signed
                          </th>
                          <th class="numeric">
                            Invoicing No DP
                          </th>
                          <th class="numeric">
                            Invoicing DP
                          </th>
                          <th class="numeric">
                            Invoicing No SECDEP
                          </th>
                          <th class="numeric">
                            Invoicing SECDEP
                          </th>
                          <th class="numeric">
                            Payment DP
                          </th>
                          <th class="numeric">
                            Payment SECDEP
                          </th>
                          <th class="numeric">
                            Nama Penyewa
                          </th>
                          <th class="numeric">
                            Alamat
                          </th>
                          <th class="numeric">
                            Telp.
                          </th>
                          <th class="numeric">
                            Email
                          </th>
                          <th class="numeric">
                            PIC
                          </th>
                        </tr>
                      </thead>
                      <tbody> 
						<?php foreach ($tenant_history as $data) : ?>
					  <tr> 
					   
					   <td><?php echo $data['rekananshipping_type']; ?></td>
					   
					   <td><?php echo $data['rekananshipping_name']; ?></td>
					   
					   <td><?php echo $data['unit_nameshort']; ?></td>
					   
					   <td><?php echo $data['loo_id'] != '' ? $data['loodetil_space'] : ''; ?></td>
					   
					   <td><?php echo $data['loo_id'] == '' ? $data['loodetil_space'] : ''; ?></td>
					   
					   <td><?php echo number_format($data['rental'], 2); ?></td>
					   
					   <td><?php echo number_format($data['SC'], 2); ?></td>
					   
					   <td><?php echo $data['loo_term']; ?></td>
					   
					   <td><?php echo $data['loo_sdate'] != '' ? date('d-m-Y',strtotime($data['loo_sdate'])) : ''; ?></td>
					   
					   <td><?php echo $data['loo_edate'] != '' ? date('d-m-Y',strtotime($data['loo_edate'])) : ''; ?></td>
					   
					   <td><?php echo $data['loi_processdate'] != '' ? date('d-m-Y',strtotime($data['loi_processdate'])) : ''; ?></td>
					   
					   <td><?php echo $data['loi_sentdate'] != '' ? date('d-m-Y',strtotime($data['loi_sentdate'])) : ''; ?></td> 
					   
					   <td><?php echo $data['loi_receivedate'] != '' ? date('d-m-Y',strtotime($data['loi_receivedate'])) : ''; ?></td>
					   
					   <td><?php echo $data['loi_signeddate'] != '' ? date('d-m-Y',strtotime($data['loi_signeddate'])) : ''; ?></td>
					   
					   <td><?php echo $data['DP_Date'] == '' ? 'No.DP' : ''; ?></td>
					   
					   <td><?php echo $data['DP_Date'] != '' ? $data['DP_Date'] : ''; ?></td>
					   
					   <td><?php echo $data['SECDEP_Date'] == '' ? 'No.SECDEP' : ''; ?></td>
					   
					   <td><?php echo $data['SECDEP_Date'] != '' ? $data['SECDEP_Date'] : ''; ?></td>
					   
					   <td><?php echo $data['DP_Payment_Date'] != '' ? date('d-m-Y',strtotime($data['DP_Payment_Date'])) : ''; ?></td>
					   
					   <td><?php echo $data['SD_Payment_Date'] != '' ? date('d-m-Y',strtotime($data['SD_Payment_Date'])) : ''; ?></td>
					   
					   <td><?php echo $data['rekanan_name']; ?></td>
					   
					   <td><?php echo $data['rekanan_address']; ?></td>
					   
					   <td><?php echo $data['rekanan_telp']; ?></td>
					   
					   <td><?php echo $data['rekanan_fax']; ?></td>
					   
					   <td><?php echo $data['rekanan_email']; ?></td>
					   
					   <td><?php echo $data['rekananshipping_contactname']; ?></td>
					   
					   </tr> 
                        <?php endforeach; ?>  
                      </tbody>
                    </table>
                  