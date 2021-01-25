 <!-- .row -->
 				<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box p-l-20 p-r-20">
                            <h3 class="box-title m-b-0">Account Setting</h3>
                            <p class="text-muted m-b-30 font-13"></p>                            
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Current Password</label>
                                        <input type="password" id="txtCurrentPassword" class="form-control" value="">
                                   	</div>
                                </div>
                                <div class="col-md-6">                                                                        
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">New Password</label>
                                        <input type="password" id="txtNewPassword" class="form-control">
                                   	</div>
                                </div>
                                <div class="col-md-6">                                                                        
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Confirm New Password</label>
                                        <input type="password" id="txtNewPassword2" class="form-control">
                                   	</div>
                                </div>
                                <div class="col-md-6">                                                                        
                                </div>
                            </div>
                                                        
                            <div class="row">                            	
                                <div class="col-sm-3">
                                	<button id="btnSave" class="btn btn-block btn-success btn-rounded">CHANGE PASSWORD</button>
                                </div>
                                <div class="col-sm-9">
                                	
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
 
 <script type="text/javascript">
 	$(document).ready(function(){	
				
		$("#btnSave").click(function() {						
			var currentPassword = $("#txtCurrentPassword").val();
			var newPassword = $("#txtNewPassword").val();
			var newPassword2 = $("#txtNewPassword2").val();
						
			if (currentPassword.trim() == '')
			{
				swal('Warning','Please fill in Current Password','warning');				
				return false;
			}		
			else if (newPassword.trim() == '')
			{
				swal('Warning','Please fill in New Password','warning');				
				return false;
			}		
			else if (newPassword2.trim() == '')
			{
				swal('Warning','Please fill in Confirm New Password','warning');				
				return false;
			}	
			else if (newPassword.trim() != newPassword2.trim())
			{
				swal('Warning','Please retype New Password','warning');				
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
						
					var v_data = {};
					v_data.currentPassword = $("#txtCurrentPassword").val();
					v_data.newPassword = $("#txtNewPassword").val();					
					
					data["header"]  = JSON.stringify(v_data);
					
					$.ajax({
						type: "POST",
						url: "<?php echo base_url();?>admin/account/change_password",
						data: {data:JSON.stringify(data)},
						dataType: 'json',
						success: function(jsonData){						
							
							if (jsonData.responseCode=="200"){
								swal({
									title: "Save Success",allowEscapeKey:false,
									text: jsonData.responseMsg, type: "success",
									confirmButtonText: "OK", closeOnConfirm: false
								});         
								
								$("#txtCurrentPassword").val('');
								$("#txtNewPassword").val('');
								$("#txtNewPassword2").val('');
																
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
		
				
		
		
	}); 
	
	
 </script>