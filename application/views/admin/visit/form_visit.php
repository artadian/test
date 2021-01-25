 <?php 
$header = $data['header'];
//print_r($data);exit;
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
                                        <label class="control-label">Visit Date</label>
                                        <input class="form-control" type="date" id="rdpTanggal" value="<?php if ($header['id']==0) { print date("Y-m-d"); } else { print $header['visitdate'];} ?>" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>                  
                                    </div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Salesman</label>
                                        <select id="cmbSalesman" class="form-control select2" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>  
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
                                        <label class="control-label">Region</label>
                                        <select id="cmbRegion" class="form-control select2" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>
                                            <?php foreach ($region as $rg): ?>                                                                  
                                                <option value="<?php echo $rg['id']; ?>" <?php if ($rg['id'] == $header['regionid']) { ?> selected="selected" <?php } ?>><?php echo $rg['name']; ?></option>
                                            <?php endforeach ?>
                                        </select>  
                                    </div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Customer</label>
                                       <select id="cmbCustomer" class="form-control select2" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>           
                                        <?php foreach ($customer as $ct): ?>                             
                                            <option value="<?php echo $ct['customerno']; ?>" <?php if ($ct['customerno'] == $header['customerno']) { ?> selected="selected" <?php } ?>><?php echo $ct['name']; ?></option>
                                        <?php endforeach ?>                                 
                                        </select>                                            
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Sales Office</label>
                                         <select id="cmbSalesOffice" class="form-control select2" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>          
                                        <?php foreach ($salesoffice as $so): ?>
                                            <option value="<?php echo $so['id']; ?>" <?php if ($so['id'] == $header['salesofficeid']) { ?> selected="selected" <?php } ?>><?php echo $so['name']; ?></option>
                                        <?php endforeach ?>                             
                                        </select>                    
                                    </div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Not Visit Reason</label>
                                       <select id="cmbnvr" class="form-control select2" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>           
                                        <?php foreach ($not_visit_reason as $nvr): ?>                             
                                            <option value="<?php echo $nvr['id']; ?>" <?php if ($nvr['id'] == $header['notvisitreason']) { ?> selected="selected" <?php } ?>><?php echo $nvr['name']; ?></option>
                                        <?php endforeach ?>                                 
                                        </select>                                            
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Not Buy Reason</label>
                                       <select id="cmbnbr" class="form-control select2" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>           
                                        <?php foreach ($not_buy_reason as $nbr): ?>                             
                                            <option value="<?php echo $nbr['id']; ?>" <?php if ($nbr['id'] == $header['notbuyreason']) { ?> selected="selected" <?php } ?>><?php echo $nbr['name']; ?></option>
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
                                    <!-- <input type="hidden" class="form-control" id="hidIndex" value="<?php print $countdetail; ?>">		                                     -->
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
			url: "<?php echo base_url();?>admin/visit/getSalesOffice",
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
			url: "<?php echo base_url();?>admin/visit/getSalesman",
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
	
	function FillCustomer()
	{		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>admin/visit/getCustomerbydate",
			data:  {
                id: $("#cmbSalesman").val(),
                date: $("#rdpTanggal").val()
                },
			dataType: 'json',
			success: function(data){																
				var html = '';
				var i;
				for(i=0; i<data.length; i++){
					html += '<option value='+data[i].customerno+'>'+data[i].name+'</option>';
				}
				$('#cmbCustomer').html(html);	
				$('#cmbCustomer').val("-").trigger('change');					
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
		$("#cmbCustomer").select2();
        $("#cmbnvr").select2();
        $("#cmbnbr").select2();
			
		<?php if ($header['id'] == '') { ?>
            FillSalesOffice();  
        <?php } ?> 
        
        <?php
            if($header["notvisitreason"]==0 && $mode == 'edit' && $header['id'] > 0){
                ?>
                $("#cmbnvr").attr("disabled", "disabled");
                <?php
            }

            if($header["notbuyreason"]==0 && $mode == 'edit'  && $header['id'] > 0){
                ?>
                $("#cmbnbr").attr("disabled", "disabled");
                <?php
            }
        ?>
		$("#btnBack").click(function() {						
			location.href="<?php echo base_url();?>admin/visit/list_visit";				
		});		 	
				
		$("#btnSubmit").click(function() {	
			// var rowCount = $('#tblDetailPOSM tr').length;			
			var visitdate = $("#rdpTanggal").val();
            var region = $("#cmbRegion").val();         
            var salesoffice = $("#cmbSalesOffice").val();         
            var salesman = $("#cmbSalesman").val();         
			var customer = $("#cmbCustomer").val();
            var nvr = $("#cmbnvr").val();			
            var nbr = $("#cmbnbr").val();
								
			if (visitdate == '')
			{
				swal('Warning','Please enter Visit Date','warning');				
				return false;
			}
            else if (region == '')
            {
                swal('Warning','Please enter Region','warning');             
                return false;
            }	
            else if (salesoffice == '')
            {
                swal('Warning','Please enter Sales Office','warning');             
                return false;
            }
            else if (salesman == '')
            {
                swal('Warning','Please enter Salesman','warning');             
                return false;
            }
			else if (customer == '-')
			{
				swal('Warning','Please select Customer','warning');				
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
                var v_data = {};	
                            
                v_data.id = $("#hidID").val();	
                v_data.customerno = $("#cmbCustomer").val();
                v_data.userid = $("#cmbSalesman").val();				
                v_data.visitdate = $("#rdpTanggal").val();
                v_data.regionid = $("#cmbRegion").val();
                v_data.salesofficeid = $("#cmbSalesOffice").val();
                v_data.nvr = $("#cmbnvr").val();
                v_data.nbr = $("#cmbnbr").val();
                                    
                data["header"]  = JSON.stringify(v_data);
                
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>admin/visit/save",
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
                                    location.href="<?php echo base_url();?>admin/visit/list_visit";		
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
			FillSalesman();
		});	

        $("#rdpTanggal").change(function() {		
			FillCustomer();
		});
		
		$("#cmbSalesman").change(function() {		
			FillCustomer();
		});

        $("#cmbnvr").change(function() {
            if ($("#cmbnvr").val() == '-'){
                $("#cmbnbr").removeAttr("disabled", "disabled");
            }else{
                $("#cmbnbr").attr("disabled", "disabled"); 	
            }
		});

        $("#cmbnbr").change(function() {
            if ($("#cmbnbr").val() == '-'){
                $("#cmbnvr").removeAttr("disabled", "disabled");
            }else{
                $("#cmbnvr").attr("disabled", "disabled"); 	
            }	
		});

        <?php if ($header['id'] > 0) { ?>
            // FillMaterialGroup();
            // FillPOSMType();
            // FillStatus();
            // FillCondition();
        <?php } ?>		
	}); 	
 </script>