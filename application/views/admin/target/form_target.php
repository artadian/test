 <?php 
$header = $data['header']; 
?>
 <!-- .row -->
 				<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box p-l-20 p-r-20">
                            <h3 class="box-title m-b-0"><?php print $page_title; ?></h3>
                            <p class="text-muted m-b-30 font-13"></p>
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Year</label>    
                                        <select id="cmbYear" class="form-control select2" <?php if ($header['id'] > 0 || $mode == 'view') { ?> disabled="disabled" <?php } ?>>			
										<?php foreach ($year as $yr): ?>																	
                                            <option value="<?php echo $yr['id']; ?>" <?php if ($yr['id'] == $header['year']) { ?> selected="selected" <?php } ?>><?php echo $yr['name']; ?></option>
                                        <?php endforeach ?>							
                                        </select>                                           
                                   	</div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Cycle</label>
                                        <select id="cmbCycle" class="form-control select2" <?php if ($header['id'] > 0 || $mode == 'view') { ?> disabled="disabled" <?php } ?>>			
											<option value="-">--- Select Cycle ---</option>
                                            <?php for ($i=1;$i<=13;$i++) { ?>
                                            <option value="<?php print $i; ?>" <?php if ($i == $header['cycle']) { ?> selected="selected" <?php } ?>><?php print $i; ?></option>
                                            <?php } ?>                                            
                                        </select>                	
                                    </div>
                                </div>
                            </div>  
                                             
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Region</label>
                                        <select id="cmbRegion" class="form-control select2" <?php if ($header['id'] > 0 || $mode == 'view') { ?> disabled="disabled" <?php } ?>>
											<?php foreach ($region as $rg): ?>																	
                                                <option value="<?php echo $rg['id']; ?>" <?php if ($rg['id'] == $header['regionid']) { ?> selected="selected" <?php } ?>><?php echo $rg['name']; ?></option>
                                            <?php endforeach ?>
                                        </select>                        
                                   	</div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                    	<label class="control-label">Salesman</label>
                                        <select id="cmbSalesman" class="form-control select2" <?php if ($header['id'] > 0 || $mode == 'view') { ?> disabled="disabled" <?php } ?>>			
										<?php foreach ($salesman as $sm): ?>																	
                                            <option value="<?php echo $sm['userid']; ?>" <?php if ($sm['userid'] == $header['userid']) { ?> selected="selected" <?php } ?>><?php echo $sm['name']; ?></option>
                                        <?php endforeach ?>									
                                        </select>                                           
                                   	</div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Sales Office</label>
                                        <select id="cmbSalesOffice" class="form-control select2" <?php if ($header['id'] > 0 || $mode == 'view') { ?> disabled="disabled" <?php } ?>>			
										<?php foreach ($salesoffice as $so): ?>																	
                                            <option value="<?php echo $so['id']; ?>" <?php if ($so['id'] == $header['salesofficeid']) { ?> selected="selected" <?php } ?>><?php echo $so['name']; ?></option>
                                        <?php endforeach ?>							
                                        </select>                                          
                                   	</div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Material Group</label>
                                        <select id="cmbMaterialGroup" class="form-control select2" <?php if ($header['id'] > 0 || $mode == 'view') { ?> disabled="disabled" <?php } ?>>			
                                        <?php foreach ($materialgroup as $mg): ?>																	
                                            <option value="<?php echo $mg['id']; ?>" <?php if ($mg['id'] == $header['materialgroupid']) { ?> selected="selected" <?php } ?>><?php echo $mg['name']; ?></option>
                                        <?php endforeach ?>									
                                        </select>              	
                                    </div>
                                </div>
                            </div> 
                            
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Call</label>
                                        <input type="text" id="txtCall" class="form-control" value="<?php print $header['call']; ?>"<?php if ($mode == 'view') { ?> disabled="disabled" <?php } ?>>  
                                   	</div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                    	<label class="control-label">Nota</label>
                                        <input type="text" id="txtNota" class="form-control" value="<?php print $header['nota']; ?>"<?php if ($mode == 'view') { ?> disabled="disabled" <?php } ?>>                                           
                                   	</div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Effective Call</label>
                                        <input type="text" id="txtEffectiveCall" class="form-control" value="<?php print $header['effectivecall']; ?>"<?php if ($mode == 'view') { ?> disabled="disabled" <?php } ?>>  
                                   	</div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                    	<label class="control-label">Volume</label>
                                        <input type="text" id="txtVolume" class="form-control" value="<?php print $header['volume']; ?>"<?php if ($mode == 'view') { ?> disabled="disabled" <?php } ?>>                                           
                                   	</div>
                                </div>
                            </div>                                                                                          
                                                                      
                            <div class="row">
                            	<div class="col-sm-2">
                                	<button id="btnBack" class="btn btn-block btn-danger btn-rounded">BACK</button>
                                </div>              
                                <div class="col-sm-8">
									<input type="hidden" class="form-control" id="hidID" value="<?php print $header['id']; ?>">		                                </div>
                                <div class="col-sm-2">                                    
                                    <button id="btnSubmit" class="btn btn-block btn-success btn-rounded" <?php if ($mode == 'view') { ?> style="display:none" <?php } ?>>SUBMIT</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
 
 <script type="text/javascript">
		
	function formatNumber(num) {
	  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
	}
	
	function isNumber(evt) {
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}

 	function FillSalesOffice()
	{	
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>admin/target/getSalesOffice",
			data:  {id: $("#cmbRegion").val()},
			dataType: 'json',
			success: function(data){																
				var html = '';
				var i;
				for(i=0; i<data.length; i++){
					html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
				}
				$('#cmbSalesOffice').html(html);	
				$('#cmbSalesOffice').val("-").trigger('change');				
			},
			error: function(jqXHR, textStatus, errorThrown ){
				swal("Error", errorThrown, "error");
			}
		});
	}
	
	function FillSalesman()
	{		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>admin/target/getSalesman",
			data:  {id: $("#cmbSalesOffice").val()},
			dataType: 'json',
			success: function(data){																
				var html = '';
				var i;
				for(i=0; i<data.length; i++){
					html += '<option value='+data[i].userid+'>'+data[i].name+'</option>';
				}
				$('#cmbSalesman').html(html);	
				$('#cmbSalesman').val("-").trigger('change');				
			},
			error: function(jqXHR, textStatus, errorThrown ){
				swal("Error", errorThrown, "error");
			}
		});
	}
	
	function FillMaterialGroup()
	{		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>admin/target/getMaterialGroup",
			data:  {id: $("#cmbSalesOffice").val()},
			dataType: 'json',
			success: function(data){																			
				var html = '';
				var i;
				for(i=0; i<data.length; i++){
					html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
				}
				$('#cmbMaterialGroup').html(html);	
				$('#cmbMaterialGroup').val("-").trigger('change');				
			},
			error: function(jqXHR, textStatus, errorThrown ){
				swal("Error", errorThrown, "error");
			}
		});
	}
		
 	$(document).ready(function(){			
				
		$("#cmbRegion").select2();
		$("#cmbSalesOffice").select2();
		$("#cmbSalesman").select2();
		$("#cmbMaterialGroup").select2();
		$("#cmbYear").select2();
		$("#cmbCycle").select2();
		
		<?php if ($header['id'] == '') { ?>				
		FillSalesOffice();	
		<?php } ?>
		
		$("#btnBack").click(function() {						
			location.href="<?php echo base_url();?>admin/target/list_target";				
		});		 	
				
		$("#btnSubmit").click(function() {	
			
			var year = $("#cmbYear").val();			
			var cycle = $("#cmbCycle").val();
			var salesman = $("#cmbSalesman").val();	
			var materialgroup = $("#cmbMaterialGroup").val();								
			var call = $("#txtCall").val();	
			var effectivecall = $("#txtEffectiveCall").val();	
			var nota = $("#txtNota").val();	
			var volume = $("#txtVolume").val();	
			
			if (year == '-')
			{
				swal('Warning','Please select Year','warning');				
				return false;
			}					
			else if (cycle == '-')
			{
				swal('Warning','Please select Cycle','warning');				
				return false;
			}	
			else if (salesman == '-')
			{
				swal('Warning','Please select Salesman','warning');				
				return false;
			}				
			else if (materialgroup == '-')
			{
				swal('Warning','Please select Material Group','warning');				
				return false;
			}				
			else if (call.trim() == '')
			{
				swal('Warning','Please enter Call','warning');				
				return false;
			}	
			else if (effectivecall.trim() == '')
			{
				swal('Warning','Please enter Effective Call','warning');				
				return false;
			}	
			else if (nota.trim() == '')
			{
				swal('Warning','Please enter Nota','warning');				
				return false;
			}	
			else if (volume.trim() == '')
			{
				swal('Warning','Please enter Volume','warning');				
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
				  confirmButtonText: "Yes, submit it!",
				  closeOnConfirm: false
				},
				function(){
					var data= new Object();
					
					var v_data = {};				
					v_data.id = $("#hidID").val();
					v_data.year = $("#cmbYear").val();
					v_data.cycle = $("#cmbCycle").val();
					v_data.userid = $("#cmbSalesman").val();	
					v_data.regionid = $("#cmbRegion").val();	
					v_data.salesofficeid = $("#cmbSalesOffice").val();	
					v_data.materialgroup = $("#cmbMaterialGroup").val();				
					v_data.call = $("#txtCall").val();
					v_data.effectivecall = $("#txtEffectiveCall").val();
					v_data.nota = $("#txtNota").val();
					v_data.volume = $("#txtVolume").val();
										
					data["header"]  = JSON.stringify(v_data);
					
					$.ajax({
						type: "POST",
						url: "<?php echo base_url();?>admin/target/save",
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
										location.href="<?php echo base_url();?>admin/target/list_target";		
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
						
		<?php if ($header['id'] == '') { ?>
		$("#cmbRegion").change(function() {					
			FillSalesOffice();
		});	
		
		$("#cmbSalesOffice").change(function() {		
			FillSalesman();
			FillMaterialGroup();
		});			
		
		<?php } ?>
	});
 </script>