 <?php 
$header = $data['header']; 
$detail = $data['detail'];
$history = $data['history']; 
?>
 <!-- .row -->
 				<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box p-l-20 p-r-20">
                            <h3 class="box-title m-b-0">Detail Send Package</h3>
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
                                            <table id="tblDokumen" class="table table-striped color-table primary-table">
                                                <thead>
                                                    <tr> 
                                                    	<th>No</th>          
                                                        <th>Revisi</th>          
                                                        <th>Type</th>                                                        
                                                        <th>Description</th>
                                                        <th>Notes</th>
                                                        <th>Qty</th>
                                                        <th>Amount</th> 
                                                        <th class="thNextStop" style="display:none">
                                                        	<!--<span class="d-inline-block" data-toggle="popover" data-content="Please select here if you choose to Split Package" data-placement="top">Next Stop</span>--> Next Stop
                                                        </th>
                                                        <th class="thCourier" style="display:none">
                                                        	<!--<span class="d-inline-block" data-toggle="popover" data-content="Please select here if you choose to Split Package" data-placement="top">Courier</span>--> Courier
                                                        </th>
                                                        <th style="display:none">TypeID</th>                                         
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
                                                        <td class="tdNextStop" style="display:none">
                                                        	<select id="cmbNextStop<?php print $i; ?>" class="form-control select2">
																<?php foreach ($userStop as $us): ?>																	
                                                                    <option value="<?php echo $us['ID']; ?>"><?php echo $us['Nama']; ?></option>
                                                                <?php endforeach ?>
                                                            </select>    	
                                                        </td>
                                                        <td class="tdCourier" style="display:none">
                                                        	<select id="cmbCourier<?php print $i; ?>" class="form-control select2">
																<?php foreach ($courier as $cr): ?>																	
                                                                    <option value="<?php echo $cr['ID']; ?>"><?php echo $cr['Nama']; ?></option>
                                                                <?php endforeach ?>
                                                            </select>      	
                                                        </td>
                                                        <td style="display:none"><?php print $detail[$i]["JenisID"]; ?></td>
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
                            
                            <div class="panel panel-danger">
                                <div class="panel-heading">Please Choose Action
                                    <div class="pull-right">                                    	
                                    </div>
                                </div>
                                <div class="panel-wrapper collapse in" style="background-color:#edf1f5" aria-expanded="true">
                                    <div class="panel-body">
                                          <div class="row">
                                            <div class="col-md-4">                                    
                                                <div class="form-group">
                                                	 <div class="radio radio-success">
                                                        <input type="radio" name="radioAction" id="radioActionSend" value="1">
                                                        <label for="radioActionSend" class="text-success"> SEND PACKAGE </label>
                                                    </div>                                                                                
                                                </div>
                                            </div>
                                            <div class="col-md-4">                                    
                                                <div class="form-group">
                                                	<div class="radio radio-info">
                                                        <input type="radio" name="radioAction" id="radioActionStop" value="2">
                                                        <label for="radioActionStop" class="text-info"> STOP PACKAGE </label>
                                                    </div>
                                               	</div>
                                            </div>
                                            <div class="col-md-4">                                    
                                                <div class="form-group">
                                                	<div class="form-group">
                                                        <div class="radio radio-primary">
                                                            <input type="radio" name="radioAction" id="radioActionSplit" value="3">
                                                            <label for="radioActionSplit" class="text-primary"> SPLIT PACKAGE </label>
                                                        </div>
                                                    </div>                                                                            
                                                </div>
                                            </div>
                                         </div>   
                                    </div>
                                </div>
                            </div>  
                            
                            <div class="row" id="divSend" style="display:none">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Next Stop</label>
                                        <input type="hidden" id="hidNextStop" value="<?php print $header['NextStop']; ?>" />
                                        <input type="hidden" id="hidRouteNow" value="<?php print $routeNow; ?>" />
                                        <select id="cmbNextStop" class="form-control select2">
                                            <?php foreach ($userStop as $us): ?>																	
                                                <option value="<?php echo $us['ID']; ?>" <?php if ($header['NextStop'] == $us['ID']) { ?> selected="selected" <?php } ?>><?php echo $us['Nama']; ?></option>
                                            <?php endforeach ?>
                                        </select>    	                            
                                    </div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Courier</label>
                                        <select id="cmbCourier" class="form-control select2">
                                            <?php foreach ($courier as $cr): ?>																	
                                                <option value="<?php echo $cr['ID']; ?>"><?php echo $cr['Nama']; ?></option>
                                            <?php endforeach ?>
                                        </select>                              
                                    </div>
                                </div>
                            </div>                                                
                                                   
                            <div class="row">
                            	<div class="col-sm-2">
                                	<button id="btnBack" class="btn btn-block btn-danger btn-rounded">BACK</button>
                                </div>              
                                <div class="col-sm-8">
                                	<input type="hidden" class="form-control" id="hidID" value="<?php print $header['ID']; ?>">
                                    <input type="hidden" class="form-control" id="hidPaketID" value="<?php print $header['PaketID']; ?>">
                                    <input type="hidden" class="form-control" id="hidRoute" value="<?php print $header['Route']; ?>">
                                    <input type="hidden" class="form-control" id="hidJumDokumen" value="<?php print count($detail); ?>">
                                    <input type="hidden" class="form-control" id="hidNotes" value="<?php print $header['Keterangan']; ?>">
                                    <input type="hidden" class="form-control" id="hidFinalStop" value="<?php print $header['FinalStopID']; ?>">
                                     <input type="hidden" class="form-control" id="hidConfidential" value="<?php print $header['Confidential']; ?>">
                                </div>
                                <div class="col-sm-2">
                                    <button id="btnSplit" class="btn btn-block btn-primary btn-rounded" style="display:none">SPLIT PACKAGE</button> 	
                                    <button id="btnStop" class="btn btn-block btn-info btn-rounded" style="display:none">STOP PACKAGE</button>      	
                                    <button id="btnSend" class="btn btn-block btn-success btn-rounded" style="display:none">SEND PACKAGE</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
 
 <script type="text/javascript">
 	$(document).ready(function(){	
		$('[data-toggle="popover"]').popover('show');
				
		$("#cmbNextStop").select2();
		$("#cmbCourier").select2();
		
		<?php for ($i=0;$i<count($detail);$i++) { ?> 
		$("#cmbNextStop<?php print $i; ?>").select2();
		$("#cmbCourier<?php print $i; ?>").select2();
		<?php } ?>
		
		$("#btnBack").click(function() {						
			location.href="<?php echo base_url();?>admin/sendpackage/send_package";				
		});		 	
				
		$("#btnSend").click(function() {	
			var nextStop = $("#cmbNextStop").val();			
			var courier = $("#cmbCourier").val();
			
			if (nextStop == '-')
			{
				swal('Warning','Please select Next Stop','warning');				
				return false;
			}					
			else if (courier == '-')
			{
				swal('Warning','Please select Courier','warning');				
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
				  confirmButtonText: "Yes, send it!",
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
					v_data.nextStop = $("#cmbNextStop").val();				
					v_data.courier = $("#cmbCourier").val();
					v_data.nextStopRoute = $("#hidNextStop").val();
					v_data.routeNow = $("#hidRouteNow").val();
					v_data.route = $("#hidRoute").val();
					
					data["header"]  = JSON.stringify(v_data);
					
					$.ajax({
						type: "POST",
						url: "<?php echo base_url();?>admin/sendpackage/send",
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
										location.href="<?php echo base_url();?>admin/sendpackage/send_package";		
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
		
		$("#btnStop").click(function() {	
			
			swal({
			  title: "Warning",
			  text: "Are you sure ?",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonClass: "btn-success",
			  confirmButtonText: "Yes, stop it!",
			  closeOnConfirm: false
			},
			function(){
				var data= new Object();
							
				var v_data = {};				
				v_data.id = $("#hidID").val();
				v_data.paketid = $("#hidPaketID").val();				
				
				data["header"]  = JSON.stringify(v_data);
				
				$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>admin/sendpackage/stop",
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
									location.href="<?php echo base_url();?>admin/sendpackage/send_package";		
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
		
		function storeTblValues()
		{
			var TableData = new Array();
		
			$('#tblDokumen tr').each(function(row, tr){
				TableData[row]={
					"no" : $(tr).find('td:eq(0)').text(),
					"revisi" : $(tr).find('td:eq(1)').text(),					
					"desc" : $(tr).find('td:eq(3)').text(),
					"notes" : $(tr).find('td:eq(4)').text(),
					"qty" : $(tr).find('td:eq(5)').text(),
					"amount" : $(tr).find('td:eq(6)').text(),
					"nextstop" : $(tr).find('td:eq(7)').find('option:selected').val(),
					"courier" : $(tr).find('td:eq(8)').find('option:selected').val(),
					"typeid" : $(tr).find('td:eq(9)').text()					
				}    
			}); 
			TableData.shift();  // first row will be empty - so remove						
			return TableData;
		}	
		
		$("#btnSplit").click(function() {	
			var jumDok = $("#hidJumDokumen").val();			
			var ok = true;
			for (var i=0;i<jumDok;i++)
			{
				if ($("#cmbNextStop" + i).val() == '-')
				{
					ok = false;
				}
				if ($("#cmbCourier" + i).val() == '-')
				{
					ok = false;
				}
			}
			
			if (ok == false)
			{
				swal('Warning','Please select Next Stop and Courier on each document','warning');				
				return false;
			}								
			else
			{
				swal({
				  title: "Warning",
				  text: "Are you sure to split package?",
				  type: "warning",
				  showCancelButton: true,
				  confirmButtonClass: "btn-success",
				  confirmButtonText: "Yes, split it!",
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
					v_data.nextStop = $("#cmbNextStop").val();				
					v_data.courier = $("#cmbCourier").val();
					v_data.nextStopRoute = $("#hidNextStop").val();
					v_data.routeNow = $("#hidRouteNow").val();
					v_data.route = $("#hidRoute").val();
					v_data.notes = $("#hidNotes").val();
					v_data.finalStop = $("#hidFinalStop").val();
					v_data.confidential = $("#hidConfidential").val();
					
					data["header"]  = JSON.stringify(v_data);
					
					$.ajax({
						type: "POST",
						url: "<?php echo base_url();?>admin/sendpackage/split",
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
										location.href="<?php echo base_url();?>admin/sendpackage/send_package";		
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
		
		$('input[type="radio"]').click(function(){
			if ($(this).is(':checked'))
			{
			   if ($(this).val() == '1') //send
			   {
				   $('#divSend').show();
				   $('#btnSend').show();
				   $('#btnStop').hide();
				   $('#btnSplit').hide();
				   $('.tdNextStop').hide();
				   $('.tdCourier').hide();
				   $('.thNextStop').hide();
				   $('.thCourier').hide();
			   }
			   else if ($(this).val() == '2') //stop
			   {
				   $('#divSend').hide();
				   $('#btnSend').hide();
				   $('#btnStop').show();
				   $('#btnSplit').hide();
				   $('.tdNextStop').hide();
				   $('.tdCourier').hide();
				   $('.thNextStop').hide();
				   $('.thCourier').hide();
			   }
			   else if ($(this).val() == '3') //split
			   {
				   $('#divSend').hide();
				   $('#btnSend').hide();
				   $('#btnStop').hide();
				   $('#btnSplit').show();
				   $('.tdNextStop').show();
				   $('.tdCourier').show();
				   $('.thNextStop').show();
				   $('.thCourier').show();
			   }
			   
			}
		  });		
		
		
	}); 	
 </script>