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
                        <div class="panel-heading">    
                            <div class="row">
                                <div class="col-md-8">
                                </div>
                                <div class="col-md-2"> 
                                    <button id="btnUpload" class="btn btn-block btn-primary btn-rounded btn-sm"><i class="fa fa-upload"></i> UPLOAD</button>
                                </div>
                                <div class="col-md-2"> 
                                    <button id="btnFilter" class="btn btn-block btn-success btn-rounded btn-sm"><i class="fa fa-filter"></i> FILTER</button>
                                </div>
                            </div> 
                            
                        </div>
                        <div class="white-box p-l-20 p-r-20">
                            <h3 class="box-title m-b-0"><?php print $page_title; ?></h3>
                            <p class="text-muted m-b-30 font-13"></p>
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
                                        <label class="control-label">Visit Day</label>
                                       <select id="cmbDay" class="form-control select2" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>           
                                        <?php foreach ($day as $dy): ?>                             
                                            <option value="<?php echo $dy['id']; ?>" <?php if ($dy['id'] == $header['day']) { ?> selected="selected" <?php } ?>><?php echo $dy['name']; ?></option>
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
                                        <label class="control-label">Visit Week</label>
                                       <select id="cmbweek" class="form-control select2" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>           
                                        <?php foreach ($week as $wk): ?>                             
                                            <option value="<?php echo $wk['id']; ?>" <?php if ($wk['id'] == $header['week']) { ?> selected="selected" <?php } ?>><?php echo $wk['name']; ?></option>
                                        <?php endforeach ?>                                 
                                        </select>                                            
                                    </div>
                                </div>
                            </div>
                                                                                                                                                    
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="white-box">
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <h3 class="box-title">LIST DETAIL MAPPING</h3>
                                            </div>                                            
                                            <!-- <div class="col-sm-2">
                                                <button id="btnAdd" class="btn btn-block btn-info btn-rounded" <?php if ($mode == 'view') { ?> style="display:none" <?php } ?>><i class="fa fa-plus"></i> ADD Customer</button>
                                            </div> -->
                                        </div>
                                        <p class="text-muted m-b-20"></p>
                                        
                                        <div class="table-responsive">
                                            <table id="tblDetailCustomerMapping" class="table table-striped color-table primary-table">
                                                <thead>
                                                    <tr>
                                                        <th style="width:20%; text-align: center;"></th>
                                                        <th style="width:20%; text-align: center; display:none">customerno</th>
                                                        <th style="width:40%; text-align: center;">Customer</th>
                                                        <th style="width:20%; text-align: center; display:none">weekid</th>     
                                                        <th style="width:16%; text-align: center;">Visit Week</th>
                                                        <th style="width:20%; text-align: center; display:none">dayid</th>  
                                                        <th style="width:16%; text-align: center;">Visit Day</th>
                                                        <th style="width:15%; text-align: center;">No Urut</th>                                                   
                                                	</tr>                                                    
                                                </thead>  
                                                <tfoot class="bg-primary text-white">
                                                    <tr></tr>                                                    
                                                </tfoot>                                             
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->                                                              
                                                                      
                            <!-- <div class="row">
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
                            </div> -->
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
			url: "<?php echo base_url();?>admin/customermapping/getSalesOffice",
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
			url: "<?php echo base_url();?>admin/customermapping/getSalesman",
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
			url: "<?php echo base_url();?>admin/customermapping/getCustomer",
			data:  {id: $("#cmbSalesman").val()},
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

    function FillDay()
	{		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>admin/customermapping/getDay",
			data:  {},
			dataType: 'json',
			success: function(data){																
				var html = '';
				var i;
				for(i=0; i<data.length; i++){
					html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
				}
				$('#cmbDay').html(html);	
				$('#cmbDay').val("-").trigger('change');					
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
		$("#cmbday").select2();
			
		<?php if ($header['id'] == '') { ?>
            FillSalesOffice();  
        <?php } ?> 

		$("#cmbRegion").change(function() {		
			FillSalesOffice();
		});	
		
		$("#cmbSalesOffice").change(function() {		
			FillSalesman();
		});	
		
		$("#cmbSalesman").change(function() {		
			FillDay();
            
            if ($("#cmbSalesOffice").val() != "-" && $("#cmbSalesman").val() != "-"){
                FillCustomer();
            } else {
                return false;
            }
		});	

		$("#tblDetailCustomerMapping").on('click','.btnDel',function(){
			$(this).closest('tr').remove();			
		});	

		$("#btnAdd").click(function() {	
            if ($("#cmbCustomer").val() == '-'){
                swal('Warning','Please select Customer','warning');             
                return false;
            }
            else{
                var idx = parseInt($("#hidIndex").val()) + 1;                   
                $("#tblDetailCustomerMapping tbody").append(
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

        $("#btnFilter").click(function() {
			table.ajax.reload();
		});

        var table = $('#tblDetailCustomerMapping').DataTable({
            "orderCellsTop": true,
            "fixedHeader": true,
            "pageLength" : 10,
            "ajax": {
                url : "<?php echo base_url();?>admin/customermapping/get_list_customermapping",
                type : 'POST',
                data : function(data) {					
                    data.regionid = $("#cmbRegion").val();
                    data.salesofficeid = $("#cmbSalesOffice").val();
                    data.salesmanid = $("#cmbSalesman").val();	
                    data.day = $("#cmbDay").val();
                    data.week = $("#cmbweek").val();	
                }				
            },
            'columnDefs': [
            {
                'targets': 0,
                "data": null,            	 	 
                "defaultContent": "<button type='button' class='btn btn-primary btn-circle btnEdit'><i class='fa fa-pencil'></i> </button> <button type='button' class='btn btn-success btn-circle btnView'><i class='fa fa-list'></i> </button> <button type='button' class='btn btn-danger btn-circle btnDelete'><i class='fa fa-close'></i> </button>",
                "width": "12%"				 
            },
            {
                'targets': [1,3,5],
                'visible': false
            }
        ],		   
        'order': [[1, 'asc']]
        });
        

        <?php if ($header['id'] > 0) { ?>
            FillMaterialGroup();
            FillPOSMType();
            FillStatus();
            FillCondition();
        <?php } ?>
        
        $("#btnUpload").click(function() {		
			location.href="<?php echo base_url();?>admin/customermapping/upload_customermapping";
		});
	}); 	
 </script>