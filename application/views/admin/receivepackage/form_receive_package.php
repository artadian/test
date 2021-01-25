<?php 
$header = $data['header']; 
$detail = $data['detail']; 
$history = $data['history']; 
?>
 <!-- .row -->
 				<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box p-l-20 p-r-20">
                            <h3 class="box-title m-b-0">Detail Receive Package </h3>
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
                                                        <th>Status</th>  
                                                        <th style="display:none">Status ID</th>
                                                        <th class="text-nowrap">Action</th>                                                    </tr>
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
                                                        <td>-</td>
                                                        <td style="display:none">0</td>
                                                        <td class="text-nowrap">                                                           	<a class="btnOK" href="#" onclick="return false;" data-toggle="tooltip" data-original-title="OK"> <button type="button" class="btn btn-success btn-circle btn-xs"><i class="fa fa-check"></i></button> </a>
                                                            <a class="btnStop" href="#" onclick="return false;" data-toggle="tooltip" data-original-title="Stop"> <button type="button" class="btn btn-danger btn-circle btn-xs"><i class="fa fa-ban"></i></button> </a>
                                                            <a class="btnCancel" href="#" onclick="return false;" data-toggle="tooltip" data-original-title="Cancel" style="display:none"> <button type="button" class="btn btn-info btn-circle btn-xs"><i class="fa fa-undo"></i></button> </a>
                                                       	</td>
                                                    </tr>
                                                	<?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->                                                         
                            <div class="row">
                            	<div class="col-sm-2">
                                	<button id="btnBack" class="btn btn-block btn-danger btn-rounded">BACK</button>
                                </div>              
                                <div class="col-sm-8">
                                	<input type="hidden" class="form-control" id="hidID" value="<?php print $header['ID']; ?>">
                                    <input type="hidden" class="form-control" id="hidPaketID" value="<?php print $header['PaketID']; ?>">
                                </div>              		
                                <div class="col-sm-2">
                                	<button id="btnFinish" class="btn btn-block btn-success btn-rounded">FINISH</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
 
 <script type="text/javascript">
 	$(document).ready(function(){	
		
		$("#btnBack").click(function() {						
			location.href="<?php echo base_url();?>admin/receivepackage/toreceive_package";				
		});		 	
				
		$("#btnFinish").click(function() {	
			var rowCount = $('#tblDokumen tr').length;	
			var counter = 0;
			for (var i=1; i<rowCount; i++) 
			{
				var status = $('#tblDokumen tr').eq(i).find('td').eq(8).text();	
				if (status == '1' || status == '2')
				{
					counter = counter + 1;
				}				
			}
						
			if (counter != (rowCount-1))
			{
				swal('Warning','Please select Status in List Document','warning');				
				return false;
			}
			else
			{
				swal({
				  title: "Warning",
				  text: "Are you sure ?",
				  type: "warning",
				  showCancelButton: true,
				  confirmButtonClass: "btn-success",
				  confirmButtonText: "Yes, save it!",
				  closeOnConfirm: false
				},
				function(){
					var data= new Object();
					
					var TableData;
					TableData = storeTblValues();
					TableData = $.toJSON(TableData);	
					data["detail"]  = TableData;
							
					var v_data = {};				
					v_data.id = $("#hidID").val();
					v_data.paketid = $("#hidPaketID").val();
									
					data["header"]  = JSON.stringify(v_data);
					
					$.ajax({
						type: "POST",
						url: "<?php echo base_url();?>admin/receivepackage/finish",
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
										location.href="<?php echo base_url();?>admin/receivepackage/toreceive_package";		
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
			}			
			
		});
		
		$("#tblDokumen").on('click','.btnOK',function(){
			var currentRow = $(this).closest("tr");			
			currentRow.find("td:eq(7)").html('<div class="label label-table label-success">OK</div>');	
			currentRow.find("td:eq(8)").html('1');	
			currentRow.find("td:eq(9)").find(".btnOK").hide();	
			currentRow.find("td:eq(9)").find(".btnStop").hide();		
			currentRow.find("td:eq(9)").find(".btnCancel").show();	
		});		
		
		$("#tblDokumen").on('click','.btnStop',function(){
			var currentRow = $(this).closest("tr");			
			currentRow.find("td:eq(7)").html('<div class="label label-table label-danger">STOP</div>');	
			currentRow.find("td:eq(8)").html('2');	
			currentRow.find("td:eq(9)").find(".btnOK").hide();	
			currentRow.find("td:eq(9)").find(".btnStop").hide();		
			currentRow.find("td:eq(9)").find(".btnCancel").show();	
		});	
		
		$("#tblDokumen").on('click','.btnCancel',function(){
			var currentRow = $(this).closest("tr");			
			currentRow.find("td:eq(7)").html('-');	
			currentRow.find("td:eq(8)").html('0');	
			currentRow.find("td:eq(9)").find(".btnOK").show();	
			currentRow.find("td:eq(9)").find(".btnStop").show();		
			currentRow.find("td:eq(9)").find(".btnCancel").hide();	
		});	
		
		function storeTblValues()
		{
			var TableData = new Array();
		
			$('#tblDokumen tr').each(function(row, tr){
				TableData[row]={
					"no" : $(tr).find('td:eq(0)').text()	
					, "status" : $(tr).find('td:eq(8)').text()				
				}    
			}); 
			TableData.shift();  // first row will be empty - so remove			
			return TableData;
		}		
		
	}); 	
 </script>