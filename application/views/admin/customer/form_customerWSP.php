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
                            <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Customer No</label>
                                        <input class="form-control" type="text" id="txtCustomerno" value="<?php echo $header["customerno"];?>"  disabled="disabled">                  
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Name</label>
                                        <input class="form-control" type="text" id="txtname" value="<?php echo $header["name"]; ?>" disabled="disabled">                  
                                    </div>
                                </div>
                            </div>                                                                              
                                                                                                                                                      
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="white-box">
                                        <div class="row">                                          
                                            <div class="col-sm-2">
                                                <button id="btnAdd" class="btn btn-block btn-info btn-rounded" <?php if ($mode == 'view') { ?> style="display:none" <?php } ?>><i class="fa fa-plus"></i> ADD WSP</button>
                                            </div>
                                        </div>
                                        <p class="text-muted m-b-20"></p>
                                        
                                        <div class="table-responsive">
                                            <table id="tblCustomerWSP" class="table table-striped color-table primary-table">
                                                <thead>
                                                    <tr>
                                                        <th style="width:13%; text-align: center;">Start Date</th> 
                                                        <th style="width:13%; text-align: center;">End Date</th>      
                                                        <th style="width:25%; text-align: center;">Material Group</th>
                                                        <th style="width:25%; text-align: center;">WSP Class</th>
                                                        <th style="width:13%; text-align: center;">WSP Code</th>      
                                                        <th style="width:13%; text-align: center;">Reason</th>      
                                                        <th style="width:10%; display:none">WSPID</th>           
                                                        <th class="text-nowrap" style="text-align: center;">Action</th>	                                                    
                                                	</tr>                                                    
                                                </thead>
                                                <tbody> 
                                                    <?php for ($i=0;$i<$countdetail;$i++) { ?>
                                                    <tr id="trCusWSP<?php print ($i+1); ?>">
                                                        <td>
                                                            <input type="date" id="startdate<?php print ($i+1); ?>" class="form-control text-right" value="<?php print $detail[$i]['startdate']; ?>">
                                                        </td>
                                                        <td>
                                                            <input type="date" id="enddate<?php print ($i+1); ?>" class="form-control text-right" value="<?php print $detail[$i]['enddate']; ?>">
                                                        </td> 
                                                        <td>
                                                            <select id="cmbMaterialGroup<?php print ($i+1); ?>" class="form-control select2" <?php if ($mode == 'view') { ?> disabled="disabled" <?php } ?>> 
                                                            <?php foreach ($materialgroup as $mg): ?>           
                                                                <option value="<?php echo $mg['id']; ?>" <?php if ($mg['id'] == $detail[$i]["materialgroup_id"]) { ?> selected="selected" <?php } ?>><?php echo $mg['name']; ?></option>
                                                            <?php endforeach ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select id="cmbWSPClass<?php print ($i+1); ?>" class="form-control select2" <?php if ($mode == 'view') { ?> disabled="disabled" <?php } ?>> 
                                                            <?php foreach ($wspclass as $wc): ?>           
                                                                <option value="<?php echo $wc['id']; ?>" <?php if ($wc['id'] == $detail[$i]["class"]) { ?> selected="selected" <?php } ?>><?php echo $wc['name']; ?></option>
                                                            <?php endforeach ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" id="txtwspcode<?php print ($i+1); ?>" class="form-control text-right" value="<?php print $detail[$i]['wspcode']; ?>">
                                                        </td>
                                                        <td>
                                                            <input type="text" id="txtreason<?php print ($i+1); ?>" class="form-control text-right" value="<?php print $detail[$i]['reason']; ?>">
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
	var arrMaterialGroup;
    var arrWSP;

	function FillMaterialGroup(){		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>admin/customer/getMaterialGroup",
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

    function FillWSPClass(){		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>admin/customer/getWSPClass",
			data:  "",
			dataType: 'json',
			success: function(data){																				
				var html = '';
				var i;
				for(i=0; i<data.length; i++){
					html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
				}
				arrWSP = html;				
			},
			error: function(jqXHR, textStatus, errorThrown ){
				swal("Error", errorThrown, "error");
			}
		});
	}
		
 	$(document).ready(function(){			
				
		<?php if ($header['id'] == '') { ?>
            FillSalesOffice();
            FillWSPClass();  
        <?php } ?> 

		$("#btnBack").click(function() {						
			location.href="<?php echo base_url();?>admin/customer/list_customer";				
		});		 	
				
		$("#btnSubmit").click(function() {       
			var customer = $("#txtCustomerno").val();			
			var rowCount = $('#tblCustomerWSP tr').length;	

			var barisKosong = '';
			for (var i=1;i<rowCount-1;i++)
			{
				var wsp = $('#tblCustomerWSP').find("tr:eq("+ i +")").find("td:eq(0)").find('option:selected').val();
				if (wsp == '-')
				{
					barisKosong = i;
					break;
				}
			}
			
			if (rowCount == 2)
			{
				swal('Warning','Please add wsp detail','warning');				
				return false;
			}

			if (barisKosong != '')
			{
				swal('Warning','Please enter Material Group, WSP Class at row ' + barisKosong,'warning');				
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
					v_data.customerno = $("#txtCustomerno").val();
										
					data["header"]  = JSON.stringify(v_data);
					
					$.ajax({
						type: "POST",
						url: "<?php echo base_url();?>admin/customer/saveWSP",
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
			}					
			
			
		});			
				
		function storeTblValues()
		{
			var TableData = new Array();
		
			$('#tblCustomerWSP tbody tr').each(function(row, tr){
				TableData[row]={
					"startdate" : $(tr).find('td:eq(0) input[type="date"]').val(),
					"enddate" : $(tr).find('td:eq(1) input[type="date"]').val(),					
					"materialgroup" : $(tr).find('td:eq(2)').find('option:selected').val(),
                    "wsp" : $(tr).find('td:eq(3)').find('option:selected').val(),	
					"wspcode" : $(tr).find('td:eq(4)  input[type="text"]').val(),
                    "reason" : $(tr).find('td:eq(5)  input[type="text"]').val(),
					"id" : $(tr).find('td:eq(6) input[type="text"]').val(),			
				}    
			}); 
			console.log(TableData);					
			return TableData;
		}

		$("#cmbMaterialGroup").change(function() {		
			FillMaterialGroup();
		});
        $("#cmbWSPClass").change(function() {		
			FillWSPClass();
		});	

		$("#tblCustomerWSP").on('click','.btnDel',function(){
			$(this).closest('tr').remove();			
		});	

		$("#btnAdd").click(function() {	
            FillMaterialGroup();
            FillWSPClass();
            var idx = parseInt($("#hidIndex").val()) + 1;                   
            $("#tblCustomerWSP tbody").append(
                '<tr id="trCusWSP' + idx +'">' +                   
                '<td>' +
                    '<input type="date" id="startdate' + idx +'" class="form-control text-right" value="0">' +  
                '</td>' + 
                '<td>' +
                    '<input type="date" id="enddate' + idx +'" class="form-control text-right" value="0">' +  
                '</td>' + 
                '<td>' +
                    '<select id="cmbMaterialGroup' + idx +'" class="form-control select2">' + arrMaterialGroup + '</select>' +   
                '</td>' + 
                '<td>' +
                    '<select id="cmbWSPClass' + idx +'" class="form-control select2">' + arrWSP + '</select>' +   
                '</td>' +     
                '<td>' +
                    '<input type="text" id="txtwspcode' + idx +'" class="form-control text-right" value="">' +
                '</td>' +
                '<td>' +
                    '<input type="text" id="txtreason' + idx +'" class="form-control text-right" value="">' +
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
		});	

        <?php if ($header['id'] > 0) { ?>
            FillMaterialGroup();
            FillWSPClass();
        <?php } ?>		
	}); 	
 </script>