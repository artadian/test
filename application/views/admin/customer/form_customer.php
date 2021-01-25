 <?php 
$header = $data['header'];
$arrRole = $arrRoute = explode(",",$header['userroleid']);
// print_r($arrRole);exit;
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
                                        <label class="control-label">Customer No</label>
                                        <input class="form-control" type="text" id="txtCustomerno" value="<?php if($header['id'] > 0 && $mode == 'view' || $mode == 'edit'){ echo $header["customerno"];} ?>"  disabled="disabled">                  
                                    </div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Price Type</label>
                                        <select id="cmbPrice" class="form-control select2" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>  
                                            <?php foreach ($price as $pr): ?>          
                                                <option value="<?php echo $pr['id']; ?>" <?php if ($pr['id'] == $header['priceid']) { ?> selected="selected" <?php } ?>><?php echo $pr['name']; ?></option>
                                            <?php endforeach ?>         
                                        </select>                                          
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Name</label>
                                        <input class="form-control" type="text" id="txtname" value="<?php if($header['id'] > 0 && $mode == 'view' || $mode == 'edit'){ echo $header["name"];} ?>" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>                  
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Region</label>
                                        <select id="cmbRegion" class="form-control select2" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>
                                            <?php foreach ($region as $rg): ?>                                                                  
                                                <option value="<?php echo $rg['id']; ?>" <?php if ($rg['id'] == $header['regionid']) { ?> selected="selected" <?php } ?>><?php echo $rg['name']; ?></option>
                                            <?php endforeach ?>
                                        </select>  
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Address</label>
                                        <textarea class="form-control" id="txtAddress" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>><?php if($header['id'] > 0 && $mode == 'view' || $mode == 'edit'){ echo $header["address"];} ?></textarea>                  
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Sales Office</label>
                                         <select id="cmbSalesOffice" class="form-control select2" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>          
                                        <?php foreach ($salesoffice as $so): ?>
                                            <option value="<?php echo $so['id']; ?>" <?php if ($so['id'] == $header['salesoffice_id']) { ?> selected="selected" <?php } ?>><?php echo $so['name']; ?></option>
                                        <?php endforeach ?>                             
                                        </select>                    
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">City</label>
                                        <input class="form-control" type="text" id="txtCity" value="<?php if($header['id'] > 0 && $mode == 'view' || $mode == 'edit'){ echo $header["city"];} ?>" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>                
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Sales Group</label>
                                        <select id="cmbSalesGroup" class="form-control select2" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>         
                                        <?php foreach ($salesgroup as $sg): ?>
                                            <option value="<?php echo $sg['id']; ?>" <?php if ($sg['id'] == $header['salesgroup_id']) { ?> selected="selected" <?php } ?>><?php echo $sg['name']; ?></option>
                                        <?php endforeach ?> 
                                        </select>                                        	
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Owner</label>
                                        <input class="form-control" type="text" id="txtOwner" value="<?php if($header['id'] > 0 && $mode == 'view' || $mode == 'edit'){ echo $header["owner"];} ?>" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>                
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Sales District</label>
                                        <select id="cmbSalesDistrict" class="form-control select2" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>
                                            <?php foreach ($salesdistrict as $sd): ?>
                                                <option value="<?php echo $sd['id']; ?>" <?php if ($sd['id'] == $header['salesdistrict_id']) { ?> selected="selected" <?php } ?>><?php echo $sd['name']; ?></option>
                                            <?php endforeach ?> 						
                                        </select>                                        	
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Phone</label>
                                        <input class="form-control" type="text" id="txtPhone" value="<?php if($header['id'] > 0 && $mode == 'view' || $mode == 'edit'){ echo $header["phone"];} ?>" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>                
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Role</label>
                                        <select id="cmbRole" class="select2 m-b-10 select2-multiple" multiple="multiple">
                                            <?php foreach ($role as $ro): ?>
                                                <option value="<?php echo $ro['id']; ?>" <?php if (in_array($ro['id'],$arrRole)) { ?> selected="selected" <?php } ?>><?php echo $ro['name']; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>                                                           
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Customer Group</label>
                                         <select id="cmbCustomerGroup" class="form-control select2" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>          
                                            <?php foreach ($customerGroup as $cg): ?>
                                                <option value="<?php echo $cg['id']; ?>" <?php if ($cg['id'] == $header['customergroup_id']) { ?> selected="selected" <?php } ?>><?php echo $cg['name']; ?></option>
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
                                    <input type="hidden" class="form-control" id="hidID" value="<?php print $header['id']; ?>">	
                                </div>
                                <div class="col-sm-2">                                    
                                    <button id="btnSubmit" class="btn btn-block btn-success btn-rounded" <?php if ($mode == 'view') { ?> style="display:none" <?php } ?>>SUBMIT</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
 
 <script type="text/javascript">
    var arrPOSMType;
	var arrMaterialGroup;
    var arrStatus;
    var arrCondition;

 	function FillSalesOffice()
	{		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>admin/posm/getSalesOffice",
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
	
	function FillSalesGroup()
	{		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>admin/customer/getSalesGroup",
			data:  {id: $("#cmbSalesOffice").val()},
			dataType: 'json',
			success: function(data){																
				var html = '';
				var i;
				for(i=0; i<data.length; i++){
					html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
				}
				$('#cmbSalesGroup').html(html);	
				$('#cmbSalesGroup').val("-").trigger('change');	
			},
			error: function(jqXHR, textStatus, errorThrown ){
				swal("Error", errorThrown, "error");
			}
		});
	}

	function FillSalesDistrict()
	{		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>admin/customer/getSalesDistrict",
			data:  {id: $("#cmbSalesGroup").val()},
			dataType: 'json',
			success: function(data){																
				var html = '';
				var i;
				for(i=0; i<data.length; i++){
					html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
				}
				$('#cmbSalesDistrict').html(html);	
				$('#cmbSalesDistrict').val("-").trigger('change');	
			},
			error: function(jqXHR, textStatus, errorThrown ){
				swal("Error", errorThrown, "error");
			}
		});
    }
		
 	$(document).ready(function(){			
				
		$("#cmbRegion").select2();
		$("#cmbSalesOffice").select2();
		$("#cmbSalesGroup").select2();
		$("#cmbSalesDistrict").select2();
        $("#cmbCustomerGroup").select2();
        $("#cmbPrice").select2();
		$("#cmbRole").select2({ 
			allowRepetitionForMultipleSelect: true
		});	
		<?php if ($header['id'] == '') { ?>
            FillSalesOffice();  
        <?php } ?> 

		$("#btnBack").click(function() {						
			location.href="<?php echo base_url();?>admin/customer/list_customer";				
		});		 	
				
		$("#btnSubmit").click(function() {
            var customerno = $("#txtCustomerno").val();		
			var price = $("#cmbPrice").val();
            var name = $("#txtname").val();         
            var region = $("#cmbRegion").val();         
            var address = $("#txtAddress").val();         
			var salesoffice = $("#cmbSalesOffice").val();
            var city = $("#txtCity").val();
            var salesgroup = $("#cmbSalesGroup").val();
            var owner = $("#txtOwner").val();
            var salesdistrict = $("#cmbSalesDistrict").val();
            var phone = $("#txtPhone").val();
            var role = $("#cmbRole").select2('data');
            console.log(role);
            var customergroup = $("#cmbCustomerGroup").val();
			
			// var barisKosong = '';
			// for (var i=1;i<rowCount-1;i++)
			// {
			// 	var materialid = $('#tblDetailPOSM').find("tr:eq("+ i +")").find("td:eq(0)").find('option:selected').val();
			// 	if (materialid == '-')
			// 	{
			// 		barisKosong = i;
			// 		break;
			// 	}
			// }
								
			if (price == ''){
				swal('Warning','Please select price type','warning');				
				return false;
			}else if (name == ''){
                swal('Warning','Please enter customer name','warning');             
                return false;
            }else if (region == ''){
                swal('Warning','Please select region','warning');             
                return false;
            }else if (address == ''){
                swal('Warning','Please enter address','warning');             
                return false;
            }else if (salesoffice == '-'){
				swal('Warning','Please select sales office','warning');				
				return false;
			}else if (city == ''){
				swal('Warning','Please enter city','warning');				
				return false;
			}else if (salesgroup == ''){
                swal('Warning','Please select sales group','warning');             
                return false;
            }else if (owner == '-'){
				swal('Warning','Please enter owner','warning');				
				return false;
			}else if (salesdistrict == ''){
				swal('Warning','Please select salesdistrict','warning');				
				return false;
			}else if (phone == ''){
                swal('Warning','Please enter phone','warning');             
                return false;
            }else if (role == '-'){
				swal('Warning','Please enter role','warning');				
				return false;
			}else if (customergroup == ''){
				swal('Warning','Please select customer group','warning');				
				return false;
			}
				
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
                 
                // var TableData;
                // TableData = storeTblValues();
                // TableData = $.toJSON(TableData);	
                // data["detail"]  = TableData;
                var arrRole = '';
				for (var i=0;i<role.length;i++){
                    arrRole = arrRole + role[i]['id'] + ',';					
				}
				arrRole = arrRole.substring(0,role.length+1);

                var v_data = {};	
                            
                v_data.id = $("#hidID").val();
                v_data.customerno = $("#txtCustomerno").val();
                v_data.price = $("#cmbPrice").val();				
                v_data.name = $("#txtname").val();
                v_data.region = $("#cmbRegion").val();
                v_data.address = $("#txtAddress").val();
                v_data.salesoffice = $("#cmbSalesOffice").val();
                v_data.city = $("#txtCity").val();
                v_data.salesgroup = $("#cmbSalesGroup").val();
                v_data.owner = $("#txtOwner").val();
                v_data.salesdistrict = $("#cmbSalesDistrict").val();
                v_data.phone = $("#txtPhone").val();
                v_data.role = arrRole;
                v_data.customergroup = $("#cmbCustomerGroup").val();
                           
                data["header"]  = JSON.stringify(v_data);
                
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>admin/customer/save",
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
                                    location.href="<?php echo base_url();?>admin/customer/list_customer";		
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
					
		$("#cmbRegion").change(function() {		
			FillSalesOffice();
		});	
		
		$("#cmbSalesOffice").change(function() {		
			FillSalesGroup();
        });
		
		$("#cmbSalesGroup").change(function() {
            FillSalesDistrict();
		});

        <?php if ($header['id'] > 0) { ?>
            FillMaterialGroup();
            FillPOSMType();
            FillStatus();
            FillCondition();
        <?php } ?>		
	}); 	
 </script>