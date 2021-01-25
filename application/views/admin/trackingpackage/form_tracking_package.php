 <!-- .row -->
 				<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box p-l-20 p-r-20">
                            <h3 class="box-title m-b-0">Tracking Package</h3>
                            <p class="text-muted m-b-30 font-13"></p>
                            <div class="row">
                                <div class="col-md-4">                                    
                                    <div class="form-group">
                                        <input type="text" id="txtTrackPackage" class="form-control" placeholder="Enter Package No" value="<?php print $nopaket; ?>" >	
                                    </div>
                                </div>
                                <div class="col-md-2">                                    
                                    <div class="form-group">
                                        <button id="btnTrackPackage" class="btn btn-block btn-primary btn-rounded"><i class="fa fa-search"></i> SEARCH</button>                  
                                   	</div>
                                </div>
                                <div class="col-md-6">                                                                        
                                </div>
                            </div>                           
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                
                <!-- .row -->
 				<div class="row" id="divResult" style="display:none">
                    <!--<div class="col-sm-12">
                        <div class="white-box p-l-20 p-r-20">
                        	<div class="row text-center">                                
                            	<div class="col-md-2 col-xs-6 b-r"> <strong>No</strong>
                                    <br>
                                    <p class="text-muted">2019090001</p>
                                </div>
                                <div class="col-md-4 col-xs-6 b-r"> <strong>From</strong>
                                    <br>
                                    <p class="text-muted">Yuana Natalia - Application Development</p>
                                </div>
                                <div class="col-md-4 col-xs-6 b-r"> <strong>To</strong>
                                    <br>
                                    <p class="text-muted">Yuana Natalia - Application Development</p>
                                </div>                                
                                <div class="col-md-2 col-xs-6"> <strong>Status</strong>
                                    <br>
                                    <p class="text-muted">STOP</p>
                                </div>
                            </div>
                            <p class="text-muted m-b-30 font-13"></p>   
                        	<div class="tracking-list">
                               <div class="tracking-item text-success">
                                  <div class="tracking-icon status-intransit bg-success"></div>
                                  <div class="tracking-date">12-09-2019 09:00<span>12-09-2019 09:30</span></div>
                                  <div class="tracking-content">[COMPLETE] Ratna Isnaning - Personnel & Welfare<span>Sent by Usman, Received by Sari Kusuma - Personnel & Welfare</span></div>
                               </div>
                               <div class="tracking-item text-info">
                                  <div class="tracking-icon status-intransit bg-info"></div>
                                  <div class="tracking-date">12-09-2019 10:00<span>12-09-2019 11:00</span></div>
                                  <div class="tracking-content">[RECEIVED] Denny Christian - Tax Gelora<span>Sent by Iwan, Received by Denny Christian - Tax Gelora</span></div>
                               </div>    
                               <div class="tracking-item text-primary">
                                  <div class="tracking-icon status-intransit bg-primary"></div>
                                  <div class="tracking-date">12-09-2019 10:00<span>12-09-2019 11:00</span></div>
                                  <div class="tracking-content">[PROGRESS] Yuana Natalia - Application Development<span>Sent by Pribadi, Received by Yuana Natalia - Application Development</span></div>
                               </div>   
                               <div class="tracking-item text-danger">
                                  <div class="tracking-icon status-intransit bg-danger"></div>
                                  <div class="tracking-date">12-09-2019 10:00<span>12-09-2019 11:00</span></div>
                                  <div class="tracking-content">[STOP] Santi Purnomosari - Accounting Gelora<span>Sent by Pribadi, Received by Santi Purnomosari - Accounting Gelora</span></div>
                               </div>                               
                            </div>
                        </div>
                    </div>-->
                </div>
                <!-- /.row -->
 
 <script type="text/javascript">
 	$(document).ready(function(){			
		
		$("#btnTrackPackage").click(function() {
			$('#divResult').hide();	
			$('#divResult').html('');		
										
			var no = $("#txtTrackPackage").val();
						
			if (no == '')
			{
				swal('Warning','Please enter package no','warning');				
				return false;
			}				
			else
			{
				var data= new Object();					
					
				var v_data = {};				
				v_data.no = no;
				
				data["header"]  = JSON.stringify(v_data);
				
				$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>admin/trackingpackage/search",
					data: {data:JSON.stringify(data)},
					dataType: 'json',
					success: function(jsonData){												
						if (jsonData['status'] == 'ok')
						{
							$('#divResult').show();	
							var durasi = '';
							if (jsonData['header'].Hari > 0)
							{
								durasi += jsonData['header'].Hari + ' days ';
							}
							if (jsonData['header'].Jam > 0)
							{
								durasi += jsonData['header'].Jam + ' hours ';
							}
							if (jsonData['header'].Menit > 0)
							{
								durasi += jsonData['header'].Menit + ' minutes ';
							}
							var str = '<div class="col-sm-12">';
							str = str + '<div class="white-box p-l-20 p-r-20">';
							str = str + '	<div class="row text-center">';
							str = str + '		<div class="col-md-2 col-xs-6 b-r"> <strong>No</strong>';
							str = str + '			<br>';
							str = str + '			<p class="text-muted">'+ jsonData['header'].No +'</p>';
							str = str + '		</div>';
							str = str + '		<div class="col-md-2 col-xs-6 b-r"> <strong>Status</strong>';
							str = str + '			<br>';
							str = str + '			<p class="text-muted">'+ jsonData['header'].Status +'</p>';
							str = str + '		</div>';
							str = str + '		<div class="col-md-3 col-xs-6 b-r"> <strong>From</strong>';
							str = str + '			<br>';
							str = str + '			<p class="text-muted">'+ jsonData['header'].Pengirim +'</p>';
							str = str + '		</div>';
							str = str + '		<div class="col-md-3 col-xs-6 b-r"> <strong>To</strong>';
							str = str + '			<br>';
							str = str + '			<p class="text-muted">'+ jsonData['header'].FinalStop +'</p>';
							str = str + '		</div>';
							str = str + '		<div class="col-md-2 col-xs-6"> <strong>Duration</strong>';
							str = str + '			<br>';
							str = str + '			<p class="text-muted">'+ durasi +'</p>';
							str = str + '		</div>';
							str = str + '	</div>';
							str = str + '	<p class="text-muted m-b-30 font-13"></p>';
							str = str + '	<div class="tracking-list">';
							for (var i=0;i<jsonData['data'].length;i++)
							{
								if (jsonData['data'][i].Status == 'COMPLETE')
								{
									str = str + '	   <div class="tracking-item text-success">';
									str = str + '		  <div class="tracking-icon status-intransit bg-success"></div>';
									str = str + '		  <div class="tracking-date">'+ jsonData['data'][i].TglKirim +'<span>'+ jsonData['data'][i].TglTerima +'</span></div>';
									str = str + '		  <div class="tracking-content">[COMPLETE] '+ jsonData['data'][i].Tujuan +'<span>Sent by '+ jsonData['data'][i].Kurir +', Received by '+ jsonData['data'][i].Penerima +'</span></div>';
									str = str + '	   </div>';
								}
								else if (jsonData['data'][i].Status == 'RECEIVED')
								{
									str = str + '	   <div class="tracking-item text-info">';
									str = str + '		  <div class="tracking-icon status-intransit bg-info"></div>';
									str = str + '		  <div class="tracking-date">'+ jsonData['data'][i].TglKirim +'<span>'+ jsonData['data'][i].TglTerima +'</span></div>';
									str = str + '		  <div class="tracking-content">[RECEIVED] '+ jsonData['data'][i].Tujuan +'<span>Sent by '+ jsonData['data'][i].Kurir +', Received by '+ jsonData['data'][i].Penerima +'</span></div>';
									str = str + '	   </div>';
								}
								else if (jsonData['data'][i].Status == 'PROGRESS')
								{
									str = str + '	   <div class="tracking-item text-primary">';
									str = str + '		  <div class="tracking-icon status-intransit bg-primary"></div>';
									str = str + '		  <div class="tracking-date">'+ jsonData['data'][i].TglKirim +'<span>'+ jsonData['data'][i].TglTerima +'</span></div>';
									str = str + '		  <div class="tracking-content">[PROGRESS] '+ jsonData['data'][i].Tujuan +'<span>Sent by '+ jsonData['data'][i].Kurir +', Received by '+ jsonData['data'][i].Penerima +'</span></div>';
									str = str + '	   </div>';
								}
								else if (jsonData['data'][i].Status == 'STOP')
								{
									str = str + '	   <div class="tracking-item text-danger">';
									str = str + '		  <div class="tracking-icon status-intransit bg-danger"></div>';
									str = str + '		  <div class="tracking-date">'+ jsonData['data'][i].TglKirim +'<span>'+ jsonData['data'][i].TglTerima +'</span></div>';
									str = str + '		  <div class="tracking-content">[STOP] '+ jsonData['data'][i].Tujuan +'<span>Sent by '+ jsonData['data'][i].Kurir +', Received by '+ jsonData['data'][i].Penerima +'</span></div>';
									str = str + '	   </div>';
								}
							}						
											
							$('#divResult').html(str);
							
						}
						else
						{
							swal('Warning','Package not found','warning');				
							return false; 
						}												
					},
					error: function(jqXHR, textStatus, errorThrown ){
						swal("Error", errorThrown, "error");
					}
				});
			}			
			
			
		});			
		
		<?php if ($nopaket != '') { ?>
		$("#btnTrackPackage").trigger("click");
		<?php } ?>
		
	}); 	
 </script>