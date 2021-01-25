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
                                        <label for="myFile" class="control-label">File Excel (.xlsx) :</label>
                                        <input type="file" id="myFile" name="myFile">                     
                                   	</div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <a href="<?php echo base_url('admin/customer/download_template') ?>">Download Template</a> 	     	
                                    </div>
                                </div>
                            </div>                     
                                                                      
                            <div class="row">
                            	<div class="col-sm-2">
                                	<button id="btnBack" class="btn btn-block btn-danger btn-rounded">BACK</button>
                                </div>              
                                <div class="col-sm-8">
								
                                </div>
                                <div class="col-sm-2">                                    
                                    <button id="btnUpload" class="btn btn-block btn-success btn-rounded">UPLOAD</button>
                                </div>
                            </div>
                            
                            <div class="row">
                            	<div class="col-sm-12">
                                	&nbsp;
                                </div>                                              
                            </div>
                            
                            <div class="row">
                            	<div class="col-sm-12">
                                	<div class="panel panel-info" style="border:1px solid #999">
                                        <div class="panel-heading" id="divHasilInfo"> 
                                        	RESULT :
                                        </div>
                                        <div class="panel-wrapper collapse in" aria-expanded="true">
                                            <div class="panel-body" id="divInfo" >
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>                                              
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
 
 <script type="text/javascript">
		
 	$(document).ready(function(){			
			
		$("#btnBack").click(function() {						
			location.href="<?php echo base_url();?>admin/customer/list_customer";				
		});		 		
		
		$("#btnUpload").click(function() {				
			var regex = /^([()a-zA-Z0-9\s_\\.\-:])+(.xlsx|.xls)$/;  
			/*Checks whether the file is a valid excel file*/  
			if (regex.test($("#myFile").val().toLowerCase())) {  
				 var xlsxflag = false; /*Flag for checking whether excel is .xls format or .xlsx format*/  
				 if ($("#myFile").val().toLowerCase().indexOf(".xlsx") > 0) {  
					 xlsxflag = true;  
				 }  				 
				 /*Checks whether the browser supports HTML5*/  
				 if (typeof (FileReader) != "undefined") {  
					 var reader = new FileReader();  
					 reader.onload = function (e) {  
						 var data = e.target.result;  
						 /*Converts the excel data in to object*/  
						 if (xlsxflag) {  
							 var workbook = XLSX.read(data, { type: 'binary' });  
						 }  
						 else {  
							 var workbook = XLS.read(data, { type: 'binary' });  
						 }  
						 /*Gets all the sheetnames of excel in to a variable*/  
						 var sheet_name_list = workbook.SheetNames;  
		  
						 var cnt = 0; /*This is used for restricting the script to consider only first sheet of excel*/  
						 //sheet_name_list.forEach(function (y) { /*Iterate through all sheets*/  
						 /*Convert the cell value to Json*/  							 
						 if (xlsxflag) {  
							 var exceljson = XLSX.utils.sheet_to_json(workbook.Sheets["Upload"]);  
						 }  
						 else {  
							 var exceljson = XLS.utils.sheet_to_row_object_array(workbook.Sheets["Upload"]);  
						 }  
						 console.log(exceljson);
						 if (exceljson.length > 0 && cnt == 0) {  						 	 
							 //BindTable(exceljson, '#tblDokumen');	
							 var TableData = new Array();
							 for (var i = 0; i < exceljson.length; i++) { 									   
								
								var cellValueName = exceljson[i]['Nama'];  										 
								if (cellValueName == null)  
									cellValueName = "";

								var cellValueAddress = exceljson[i]['Address'];  										 
								if (cellValueAddress == null)  
									cellValueAddress = "";

								var cellValueCity = exceljson[i]['City'];  										 
								if (cellValueCity == null)  
									cellValueCity = "";

								var cellValueOwner = exceljson[i]['Owner'];
								if (cellValueOwner == null)  										 									 
									cellValueOwner = "";

								var cellValuePhone = exceljson[i]['Phone'];  										 
								if (cellValuePhone == null)  
									cellValuePhone = "";

								var cellValueCustomerGroup = exceljson[i]['Customer_Group']; 
								if (cellValueCustomerGroup == null)
									cellValueCustomerGroup = "";

								var cellValuePriceType = exceljson[i]['Price_Type'];  	
								if (cellValuePriceType == null)  
									cellValuePriceType = "";

								var cellValueRegion = exceljson[i]['Region'];  	
								if (cellValueRegion == null)  
									cellValueRegion = "";

								var cellValueSalesOffice = exceljson[i]['Sales_Office'];  	
								if (cellValueSalesOffice == null)  
									cellValueSalesOffice = "";

								var cellValueSalesGroup = exceljson[i]['Sales_Group'];  	
								if (cellValueSalesGroup == null)  
									cellValueSalesGroup = "";

								var cellValueSalesDistrict = exceljson[i]['Sales_District'];  	
								if (cellValueSalesDistrict == null)  
									cellValueSalesDistrict = "";

								var cellValueRole = exceljson[i]['Role'];  	
								if (cellValueRole == null)  
									cellValueRole = "";
								
								TableData[i]={
									"Nama" : cellValueName.trim()
									, "Address" : cellValueAddress.trim()
									, "City" : cellValueCity.trim()
									, "Owner" : cellValueOwner.trim()
									, "Phone" : cellValuePhone.trim()
									, "Customer_Group" : cellValueCustomerGroup.trim()
									, "Price_Type" : cellValuePriceType.trim()
									, "Region" : cellValueRegion.trim()
									, "Sales_Office" : cellValueSalesOffice.trim()
									, "Sales_Group" : cellValueSalesGroup.trim()
									, "Sales_District" : cellValueSalesDistrict.trim()
									, "Role" : cellValueRole.trim()
								}    									
								
							 }  
							 
							 TableData = $.toJSON(TableData);	
							 var data= new Object();
							 data["detail"]  = TableData;	
							 
							 $.ajax({
								type: "POST",
								url: "<?php echo base_url();?>admin/customer/upload",
								data: {data:JSON.stringify(data)},
								dataType: 'json',
								success: function(jsonData){						
									var msg = jsonData.responseMsg.split('|');
									swal({
										title: "Save Success",allowEscapeKey:false,
										text: "Upload finished", type: "success",
										confirmButtonText: "OK", closeOnConfirm: false
									});
									$('#divHasilInfo').html("RESULT : " + msg[1] + " success, " + msg[2] + " failed");        
									$('#divInfo').html(msg[0]);    
									
													
								},
								error: function(jqXHR, textStatus, errorThrown ){
									swal("Error", errorThrown, "error");
								}
							});						 
							cnt++;  
						 }  
						 //});  
						 //$('#exceltable').show();  
					 }  
					 if (xlsxflag) {/*If excel file is .xlsx extension than creates a Array Buffer from excel*/  
						 reader.readAsArrayBuffer($("#myFile")[0].files[0]);  
					 }  
					 else {  
						 reader.readAsBinaryString($("#myFile")[0].files[0]);  
					 }  
					 //$('#modalUpload').modal('toggle');		
					 //$("#myFile").val();
					 var $el = $('#myFile');
					 $el.wrap('<form>').closest('form').get(0).reset();
					 $el.unwrap();
				 }  
				 else {  
					 swal("Error", "Sorry! Your browser does not support HTML5!", "error");					 
				 }  
			 }  
			 else { 
			 	 swal("Error", "Please upload a valid Excel file!", "error");					 
			 }  
		});							
		
	});
 </script>