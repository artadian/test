 <?php 
$header = $data['header']; 
$detail = $data['detail'];
$history = $data['history']; 
?>
 <!-- .row -->
 				<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box p-l-20 p-r-20">
                            <h3 class="box-title m-b-0">Detail Sent Package</h3>
                            <p class="text-muted m-b-30 font-13"></p>
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Package No</label>    
                                        <input type="text" id="txtNo" class="form-control" disabled value="<?php print $header['No']; ?>">                                    </div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Date</label>
                                        <input type="text" id="txtTgl" class="form-control" disabled value="<?php print $header['Tanggal']; ?>">                                	
                                    </div>
                                </div>
                            </div>                                                                              
                            
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">From</label>
                                        <input type="text" id="txtFrom" class="form-control" disabled value="<?php print $header['Dari']; ?>">                                                                  
                                   	</div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                    	<label class="control-label">Notes</label>
                                        <input type="text" id="txtNotesHeader" class="form-control" disabled value="<?php print $header['Keterangan']; ?>">                                                        
                                   	</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="white-box">                                        
                                    	<h3 class="box-title">ROUTE</h3>
                                        <p class="text-muted m-b-20"></p>                                        
                                        <div class="tracking-list">
                                        	<div class="tracking-item text-success">
                                              <div class="tracking-icon status-intransit bg-success"></div>
                                              <div class="tracking-date"><span></span></div>
                                              <div class="tracking-content">[SENDER] <?php print $header['Dari']; ?></div>
                                            </div>
                                        	<?php
											$countHistory = 0;
											$arrRoute = explode(',',$header['NamaRoute']);	
											$arrRouteID = explode(',',$header['Route']);	
											$routeNow = $header['RouteNow'];
											for ($i=0;$i<count($arrRouteID);$i++)
											{
												$rt = substr($arrRouteID[$i],0,strlen($arrRouteID[$i])-1);
												$kode = substr($arrRouteID[$i],-1);
												if ($kode == 'D' && $i <= $routeNow) {
											?>
                                            <div class="tracking-item text-success">
                                              <div class="tracking-icon status-intransit bg-success"></div>
                                              <div class="tracking-date"><?php print $history[$countHistory]['TglKirim']; ?><span><?php print $history[$countHistory]['TglTerima']; ?></span></div>
                                              <div class="tracking-content">[DEFAULT] <?php print $arrRoute[$i]; ?></div>
                                            </div>
                                            <?php $countHistory ++; } else if ($kode == 'D' && $i > $routeNow) {?>
                                            <div class="tracking-item text-inverse">
                                              <div class="tracking-icon status-intransit bg-inverse"></div>
                                              <div class="tracking-date"></div>
                                              <div class="tracking-content">[DEFAULT] <?php print $arrRoute[$i]; ?></div>
                                           </div>
                                           <?php } else if ($kode == 'S') {?>
                                           <div class="tracking-item text-danger">
                                              <div class="tracking-icon status-intransit bg-danger"></div>
                                              <div class="tracking-date"></div>
                                              <div class="tracking-content">[SKIP] <?php print $arrRoute[$i]; ?></div>
                                           </div>    
                                           <?php } else if ($kode == 'N') {?>
                                           <div class="tracking-item text-info">
                                              <div class="tracking-icon status-intransit bg-info"></div>
                                              <div class="tracking-date"><?php print $history[$countHistory]['TglKirim']; ?><span><?php print $history[$countHistory]['TglTerima']; ?></span></div>
                                              <div class="tracking-content">[NEW] <?php print $arrRoute[$i]; ?></div>
                                           </div>    
										   <?php $countHistory ++; }} ?>	                                    	
                                    	</div>
                                    </div>
                                </div>
                            </div>                                                   
                            <?php if ($header['Confidential'] == '2') { ?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="white-box">
                                        <h3 class="box-title">LIST DOCUMENT</h3>
                                        <p class="text-muted m-b-20"></p>
                                        
                                        <div class="table-responsive">
                                            <table id="tblDokumen" class="table table-striped">
                                                <thead>
                                                    <tr> 
                                                    	<th>No</th>          
                                                        <th>Revisi</th>          
                                                        <th>Type</th>                                                        
                                                        <th>Description</th>
                                                        <th>Notes</th>
                                                        <th>Qty</th>
                                                        <th>Amount</th>                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>                               
                                                	<?php for ($i=0;$i<count($detail);$i++) { ?>                                         
                                                	<tr>                                                    	
                                                        <td><?php print $detail[$i]["No"]; ?></td>
                                                        <td><?php print $detail[$i]["Revisi"]; ?></td>
                                                        <td><?php print $detail[$i]["Jenis"]; ?></td>
                                                        <td><?php print $detail[$i]["Deskripsi"]; ?></td>
                                                        <td><?php print $detail[$i]["Keterangan"]; ?></td>
                                                        <td><?php print $detail[$i]["Jumlah"]; ?></td>
                                                        <td><?php print $detail[$i]["Nominal"]; ?></td>
                                                    </tr>
                                                	<?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->  
                            <?php } ?>                          
                            <div class="row">
                            	<div class="col-sm-2">
                                	<button id="btnBack" class="btn btn-block btn-danger btn-rounded">BACK</button>
                                </div>              
                                <div class="col-sm-6">
                                	<input type="hidden" class="form-control" id="hidID" value="<?php print $header['ID']; ?>">
                                    <input type="hidden" class="form-control" id="hidHistoryID" value="<?php print $header['HistoryID']; ?>">
                                    <input type="hidden" class="form-control" id="hidPaketID" value="<?php print $header['PaketID']; ?>">
                                    <input type="hidden" class="form-control" id="hidHistoryPengirim" value="<?php print $header['HistoryPengirim']; ?>">
                                    <input type="hidden" class="form-control" id="hidHistoryTujuan" value="<?php print $header['HistoryTujuan']; ?>">
                                    <input type="hidden" class="form-control" id="hidPengirim" value="<?php print $header['Pengirim']; ?>">
                                    <input type="hidden" class="form-control" id="hidTujuan" value="<?php print $header['Tujuan']; ?>">
                                    <input type="hidden" class="form-control" id="hidStatus" value="<?php print $header['Status']; ?>">
                                </div>              		
                                <div class="col-sm-2">
                                    
                                </div>
                                <div class="col-sm-2">      
                                	<?php if (($header['Status'] == 'COMPLETE' && $header['HistoryID'] > 0) || ($header['Status'] == 'STOP' && $header['JumStop'] == 0)) { ?>                              
                                	<button id="btnCancel" class="btn btn-block btn-success btn-rounded">CANCEL</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
 
 <script type="text/javascript">
 	$(document).ready(function(){	
		
		$("#btnBack").click(function() {							
			location.href="<?php echo base_url();?>admin/sentpackage/sent_package";				
		});		 	
				
		$("#btnCancel").click(function() {	
			
			swal({
			  title: "Warning",
			  text: "Are you sure ?",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonClass: "btn-success",
			  confirmButtonText: "Yes, cancel it!",
			  closeOnConfirm: false
			},
			function(){
				var data= new Object();
				
				var v_data = {};				
				v_data.id = $("#hidID").val();
				v_data.paketid = $("#hidPaketID").val();	
				v_data.historyid = $("#hidHistoryID").val();	
				v_data.historypengirim = $("#hidHistoryPengirim").val();
				v_data.historytujuan = $("#hidHistoryTujuan").val();	
				v_data.pengirim = $("#hidPengirim").val();
				v_data.tujuan = $("#hidTujuan").val();
				v_data.status = $("#hidStatus").val();				
								
				data["header"]  = JSON.stringify(v_data);
				
				$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>admin/sentpackage/cancel",
					data: {data:JSON.stringify(data)},
					dataType: 'json',
					success: function(jsonData){						
						
						if (jsonData.responseCode=="200"){
							swal({
								title: "Save Success",allowEscapeKey:false,
								text: jsonData.responseMsg, type: "success",
								confirmButtonText: "OK", closeOnConfirm: false
							},
								function () {
									location.href="<?php echo base_url();?>admin/sentpackage/sent_package";		
							});                   							
							
						}else{
							 swal("Error", jsonData.responseMsg, "error");                    
						}							
					},
					error: function(jqXHR, textStatus, errorThrown ){
						swal("Error", errorThrown, "error");
					}
				});
				
				
			});
								
			
			
		});	
		
	});			
			
 </script>