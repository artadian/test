 <?php 
$header = $data['header']; 
$detail = $data['detail'];
if (empty($detail)) {
    $countdetail = 0;
} else {
    $countdetail = count($detail);
}
?>
 <!-- .row -->
 				<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box p-l-20 p-r-20">
                            <h3 class="box-title m-b-0"><?php print $page_title; ?></h3>
                            <p class="text-muted m-b-30 font-13"></p>
                                                                                                                                                       
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="white-box">
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <h3 class="box-title">LIST DETAIL POSM</h3>
                                            </div>                                            
                                            <div class="col-sm-2">
                                                <button id="btnAdd" class="btn btn-block btn-info btn-rounded" <?php if ($mode == 'view') { ?> style="display:none" <?php } ?>><i class="fa fa-plus"></i> ADD POSM</button>
                                            </div>
                                        </div>
                                        <p class="text-muted m-b-20"></p>
                                        
                                        <div class="table-responsive">
                                            <table id="tblDetailPOSM" class="table table-striped color-table primary-table">
                                                <thead>
                                                    <tr>
                                                        <th style="width:20%; text-align: center;">POSM Type</th>     
                                                        <th style="width:27%; text-align: center;">Material Group</th>
                                                        <th style="width:16%; text-align: center;">Status</th>
                                                        <th style="width:7%; text-align: center;">Qty</th>
                                                        <th style="width:10%; text-align: center;">Condition</th>
                                                        <th style="width:20%; text-align: center;">Notes</th>          
                                                        <th style="width:10%; display:none">POSMID</th>           
                                                        <th class="text-nowrap" style="text-align: center;">Action</th>	                                                    
                                                	</tr>                                                    
                                                </thead>
                                                <tbody> 
                                                    <?php for ($i=0;$i<$countdetail;$i++) { ?>
                                                    <tr id="trDtPOSM<?php print ($i+1); ?>">	
                                                        <td>
                                                            <select id="cmbPOSMType<?php print ($i+1); ?>" class="form-control select2" <?php if ($mode == 'view') { ?> disabled="disabled" <?php } ?>> 
                                                            <?php foreach ($posmtype as $pt): ?>           
                                                                <option value="<?php echo $pt['id']; ?>" <?php if ($pt['id'] == $detail[$i]["posmtypeid"]) { ?> selected="selected" <?php } ?>><?php echo $pt['name']; ?></option>
                                                            <?php endforeach ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select id="cmbMaterialGroup<?php print ($i+1); ?>" class="form-control select2" <?php if ($mode == 'view') { ?> disabled="disabled" <?php } ?>> 
                                                            <?php foreach ($materialgroup as $mg): ?>                                                                    
                                                                <option value="<?php echo $mg['id']; ?>" <?php if ($mg['id'] == $detail[$i]["materialgroupid"]) { ?> selected="selected" <?php } ?>><?php echo $mg['name']; ?></option>
                                                            <?php endforeach ?>
                                                            </select>
                                                        </td> 
                                                        <td>
                                                            <select id="cmbStatus<?php print ($i+1); ?>" class="form-control select2" <?php if ($mode == 'view') { ?> disabled="disabled" <?php } ?>> 
                                                            <?php foreach ($status as $st): ?>                        
                                                                <option value="<?php echo $st['id']; ?>" <?php if ($st['id'] == $detail[$i]["status"]) { ?> selected="selected" <?php } ?>><?php echo $st['name']; ?></option>
                                                            <?php endforeach ?>
                                                            </select>
                                                        </td> 
                                                        <td>
                                                            <!-- <?php print($detail[$i]["status"]); ?> -->
                                                            <input type="text" id="txtQty<?php print ($i+1); ?>" class="form-control text-right" value="<?php print $detail[$i]['qty']; ?>">
                                                        </td> 
                                                        <td>
                                                            <select id="cmbCondition<?php print ($i+1); ?>" class="form-control select2"> 
                                                            <?php foreach ($condition as $cd): ?>     
                                                                <option value="<?php echo $cd['id']; ?>" <?php if ($cd['id'] == $detail[$i]["condition"]) { ?> selected="selected" <?php } ?>><?php echo $cd['name']; ?></option>
                                                            <?php endforeach ?>
                                                            </select>
                                                        </td> 
                                                        <td>
                                                            <input type="text" id="txtNotes<?php print ($i+1); ?>" class="form-control text-right" value="<?php print $detail[$i]['notes']; ?>">
                                                        </td>
                                                        <td style="width:12%; display:none">
                                                            <input type="text" id="txtID<?php print ($i+1); ?>" class="form-control" disabled="disabled" value="<?php print $detail[$i]['id']; ?>">
                                                        </td> 
                                                        <td class="text-nowrap" <?php if ($mode == 'view') { ?> style="display:none" <?php } ?>>
                                                            <a class="btnDel" href="#" onclick="return false;" data-toggle="tooltip" data-original-title="Delete"> <button type="button" class="btn btn-danger btn-circle btn-xs"><i class="fa fa-close"></i></button> </a>
                                                        </td>
                                                    </tr>                                                	
                                                	<?php } ?>
                                                </tbody>  
                                                <tfoot class="bg-primary text-white">
                                                    <tr></tr>                                                    
                                                </tfoot>                                             
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
									<input type="hidden" class="form-control" id="hidID" value="<?php print $header['id']; ?>">		
                                    <input type="hidden" class="form-control" id="hidIndex" value="<?php print $countdetail; ?>">		                                    
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


	
	function FillSalesman()
	{		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>admin/posm/getSalesman",
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
			url: "<?php echo base_url();?>admin/posm/getCustomerByDate",
            data:  {
                id: $("#cmbSalesman").val(),
                date : $("#rdpTanggal").val()
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

	function FillMaterialGroup()
	{		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>admin/posm/getMaterialGroup",
			data:  {id: $("#cmbSalesOffice").val()},
			dataType: 'json',
			success: function(data){																				
				var html = '';
				var i;
				for(i=0; i<data.length; i++){
					html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
				}
				arrMaterialGroup = html;				
			},
			error: function(jqXHR, textStatus, errorThrown ){
				swal("Error", errorThrown, "error");
			}
		});
	}

    function FillPOSMType()
    {       
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>admin/posm/getPOSMType",
            data:  {
                salesofficeid: $("#cmbSalesOffice").val(), 
                userid : $("#cmbSalesman").val()
            },
            dataType: 'json',
            success: function(data){     
                if (data.length > 0){
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
                    }
                    arrPOSMType = html;
                }                
            },
            error: function(jqXHR, textStatus, errorThrown ){
                swal("Error", errorThrown, "error");
            }
        });
    }

    function FillStatus()
    {       
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>admin/posm/getLookup",
            data:  {
                lookupkey: 'posm_status'
            },
            dataType: 'json',
            success: function(data){     
                if (data.length > 0){
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
                    }
                    arrStatus = html;
                }                
            },
            error: function(jqXHR, textStatus, errorThrown ){
                swal("Error", errorThrown, "error");
            }
        });
    }

    function FillCondition()
    {       
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>admin/posm/getLookup",
            data:  {
                lookupkey: 'posm_condition'
            },
            dataType: 'json',
            success: function(data){     
                if (data.length > 0){
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
                    }
                    arrCondition = html;
                }                
            },
            error: function(jqXHR, textStatus, errorThrown ){
                swal("Error", errorThrown, "error");
            }
        });
    }
		
 	$(document).ready(function(){			
				

        
		<?php if ($header['id'] == '') { ?>
            // FillSalesOffice();  
        <?php } ?> 

		$("#btnBack").click(function() {						
			location.href="<?php echo base_url();?>admin/posm/list_posm";				
		});		 	
				
		$("#btnSubmit").click(function() {	
			var rowCount = $('#tblDetailPOSM tr').length;			
			var posmdate = $("#rdpTanggal").val();
            var region = $("#cmbRegion").val();         
            var salesoffice = $("#cmbSalesOffice").val();         
            var salesman = $("#cmbSalesman").val();         
			var customer = $("#cmbCustomer").val();			
			
			var barisKosong = '';
			for (var i=1;i<rowCount-1;i++)
			{
				var materialid = $('#tblDetailPOSM').find("tr:eq("+ i +")").find("td:eq(0)").find('option:selected').val();
				if (materialid == '-')
				{
					barisKosong = i;
					break;
				}
			}
								
			if (posmdate == '')
			{
				swal('Warning','Please enter POSM Date','warning');				
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
			else if (rowCount == 2)
			{
				swal('Warning','Please add material','warning');				
				return false;
			}

			if (barisKosong != '')
			{
				swal('Warning','Please enter POSM Type, Material Group, Status at row ' + barisKosong,'warning');				
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
					
					var TableData;
					TableData = storeTblValues();
					TableData = $.toJSON(TableData);	
					data["detail"]  = TableData;
					var v_data = {};	
                    			
					v_data.id = $("#hidID").val();	
					v_data.customerno = $("#cmbCustomer").val();
                    v_data.userid = $("#cmbSalesman").val();				
                    v_data.posmdate = $("#rdpTanggal").val();
                    v_data.regionid = $("#cmbRegion").val();
					v_data.salesofficeid = $("#cmbSalesOffice").val();
										
					data["header"]  = JSON.stringify(v_data);
					
					$.ajax({
						type: "POST",
						url: "<?php echo base_url();?>admin/posm/save",
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
										location.href="<?php echo base_url();?>admin/posm/list_posm";		
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
				
		function storeTblValues()
		{
			var TableData = new Array();
		
			$('#tblDetailPOSM tbody tr').each(function(row, tr){
				TableData[row]={
					"posmtypeid" : $(tr).find('td:eq(0)').find('option:selected').val(),
					"materialgroupid" : $(tr).find('td:eq(1)').find('option:selected').val(),					
					"status" : $(tr).find('td:eq(2)').find('option:selected').val(),
                    "qty" : $(tr).find('td:eq(3) input[type="text"]').val(),	
					"condition" : $(tr).find('td:eq(4)').find('option:selected').val(),	
					"notes" : $(tr).find('td:eq(5) input[type="text"]').val(),
					"id" : $(tr).find('td:eq(6) input[type="text"]').val(),			
				}    
			}); 
			console.log(TableData);					
			return TableData;
		}	
		$("#cmbRegion").change(function() {		
			FillSalesOffice();
		});	
		
		$("#cmbSalesOffice").change(function() {		
			FillSalesman();
		});

        <?php for ($i=0;$i<count((array)$detail);$i++) { ?> 
        // console.log(idx);
        $("#cmbStatus<?php print ($i+1); ?>").change(function() {       
            
            FillCondition();
            if ($("#cmbStatus<?php print ($i+1); ?>").val() == '1'){
                $("#txtQty<?php print ($i+1); ?>").removeAttr("readonly", true);

                $("#cmbCondition<?php print ($i+1); ?>").attr("disabled", "disabled");
                $("#cmbCondition<?php print ($i+1); ?>").val("-");

                $("#txtNotes<?php print ($i+1); ?>").attr("readonly", true);
                $("#txtNotes<?php print ($i+1); ?>").val("");
            } else {
                
                $("#txtQty<?php print ($i+1); ?>").attr("readonly", true);
                $("#txtQty<?php print ($i+1); ?>").val("0");

                $("#cmbCondition<?php print ($i+1); ?>").removeAttr("disabled", "disabled");
                $("#txtNotes<?php print ($i+1); ?>").removeAttr("readonly", true);
            }
        });
        if ($("#cmbStatus<?php print ($i+1); ?>").val() == '1'){
            $("#txtQty<?php print ($i+1); ?>").removeAttr("readonly", true);
            $("#cmbCondition<?php print ($i+1); ?>").attr("disabled", "disabled");
            $("#txtNotes<?php print ($i+1); ?>").attr("readonly", true);
        }else {
            $("#txtQty<?php print ($i+1); ?>").attr("readonly", true);
            $("#cmbCondition<?php print ($i+1); ?>").removeAttr("disabled", "disabled");
            $("#txtNotes<?php print ($i+1); ?>").removeAttr("readonly", true);
        }
        <?php } ?> 
		
		$("#cmbSalesman").change(function() {		
			FillCustomer();
            FillMaterialGroup();
            
            if ($("#cmbSalesOffice").val() != "-" && $("#cmbSalesman").val() != "-"){
                FillPOSMType();
                FillStatus();
                FillCondition();
            } else {
                return false;
            }
		});	

		$("#tblDetailPOSM").on('click','.btnDel',function(){
			$(this).closest('tr').remove();			
		});	

		$("#btnAdd").click(function() {	
            if ($("#cmbCustomer").val() == '-'){
                swal('Warning','Please select Customer','warning');             
                return false;
            }
            else{
                var idx = parseInt($("#hidIndex").val()) + 1;                   
                $("#tblDetailPOSM tbody").append(
                    '<tr id="trDtPOSM' + idx +'">' +                   
                    '<td>' +
                        '<select id="cmbPOSMType' + idx +'" class="form-control select2">' + arrPOSMType + '</select>' +   
                    '</td>' + 
                    '<td>' +
                        '<select id="cmbMaterialGroup' + idx +'" class="form-control select2">' + arrMaterialGroup + '</select>' +   
                    '</td>' + 
                    '<td>' +
                        '<select id="cmbStatus' + idx +'" class="form-control select2">' + arrStatus + '</select>' +   
                    '</td>' +     
                    '<td>' +
                        '<input type="text" id="txtQty' + idx +'" class="form-control text-right" value="0">' +
                    '</td>' +
                    '<td>' +
                        '<select id="cmbCondition' + idx +'" class="form-control select2">' + arrCondition + '</select>' +   
                    '</td>' +     
                    '<td>' +
                        '<input type="text" id="txtNotes' + idx +'" class="form-control text-right" value="">' +
                    '</td>' +
                    '<td style="display:none">' +
                        '<input type="text" id="txtID' + idx +'" value="0" class="form-control" disabled="disabled">' +
                    '</td>' +  
                    '<td class="text-nowrap">' +
                        '<a class="btnDel" href="#" onclick="return false;" data-toggle="tooltip" data-original-title="Delete"> <button type="button" class="btn btn-danger btn-circle btn-xs"><i class="fa fa-close"></i></button> </a>' +
                    '</td>' +
                    '</tr>'
                );
                $("#hidIndex").val(idx); 

                $("#cmbStatus" + idx).change(function() {             
                    if ($("#cmbStatus" + idx).val() == '1'){
                        $("#txtQty" + idx).attr("readonly", false);
                        $("#cmbCondition" + idx).attr("disabled", "disabled");
                        $("#cmbCondition" + idx).val("-");
                        
                        $("#txtNotes" + idx).attr("readonly", true);
                        $("#txtNotes" + idx).val("");
                    } else {
                        $("#txtQty" + idx).attr("readonly", true);
                        $("#txtQty" + idx).val("0");
                        $("#cmbCondition" + idx).removeAttr("disabled", "disabled");
                        $("#txtNotes" + idx).attr("readonly", false);
                    }
                }); 
            }							
		});	

        <?php if ($header['id'] > 0) { ?>
            FillMaterialGroup();
            FillPOSMType();
            FillStatus();
            FillCondition();
        <?php } ?>		
	}); 	
 </script>