 <?php 
$header = $data['header']; 
// print_r($header['id']); exit();
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
                                        <label class="control-label">Trial Date</label>
                                        <input class="form-control" type="date" id="rdpTanggal" value="<?php if ($header['id']==0) { print date("Y-m-d"); } else { print $header['trialdate'];} ?>" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>                        
                                    </div>
                                </div>
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
                                        <label class="control-label">Trial Type</label>
                                        <select id="cmbTrialType" class="form-control select2" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>   
                                            <?php foreach ($trialtype as $tr): ?> 
                                                <option value="<?php echo $tr['id']; ?>" <?php if ($tr['id'] == $header['trialtypevalue']) { ?> selected="selected" <?php } ?>><?php echo $tr['name']; ?></option> 
                                            <?php endforeach ?>                        
                                        </select>                                           
                                    </div>   
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                    	<div class="form-group">
                                            <label class="control-label">Location</label>    
                                            <input type="text" id="txtLocation" class="form-control" value="<?php print $header['location']; ?>" placeholder="Location" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>                                    
                                        </div>                                    
                                   	</div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="control-label">Name</label>    
                                            <input type="text" id="txtName" class="form-control" value="<?php print $header['name']; ?>" placeholder="Name" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>                                    
                                        </div>                                    
                                    </div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="control-label">Phone</label>    
                                            <input type="text" id="txtPhone" class="form-control" value="<?php print $header['phone']; ?>" placeholder="Phone" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>                                    
                                        </div>                                    
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="control-label">Age</label>    
                                            <input type="text" id="txtAge" class="form-control" value="<?php print $header['age']; ?>" placeholder="Age" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>                                    
                                        </div>                                    
                                    </div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Material</label>
                                        <select id="cmbMaterial" class="form-control select2" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>  
                                            <?php foreach ($material as $mt): ?>           
                                                <option value="<?php echo $mt['id']; ?>" <?php if ($mt['id'] == $header['materialid']) { ?> selected="selected" <?php } ?>><?php echo $mt['name']; ?></option>
                                            <?php endforeach ?>         
                                        </select>  
                                        <input type="text" id="txtMaterialGroupId" class="form-control" disabled="disabled" value="" style="display: none;">                                         
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="control-label">Qty</label>    
                                            <input type="text" id="txtQty" class="form-control" value="<?php print $header['qty']; ?>" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>                              
                                        </div>                                    
                                    </div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Price</label>
                                        <input type="text" id="txtPrice" class="form-control" value="<?php print $header['price']; ?>" readonly="readonly" >
                                        <input type="text" id="txtPriceAsli" class="form-control" disabled="disabled" value="" style="display: none;">                                            
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="control-label">Total</label>    
                                            <input type="text" id="txtTotal" class="form-control" value="<?php print $header['total']; ?>" readonly="readonly">
                                            <input type="text" id="txtTotalAsli" class="form-control" disabled="disabled" value="" style="display: none;">                                
                                        </div>                                    
                                    </div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Brand Before</label>
                                        <select id="cmbBrandBefore" class="form-control select2" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>> 
                                            <?php foreach ($brandbefore as $bf): ?>           
                                                <option value="<?php echo $bf['id']; ?>" <?php if ($bf['id'] == $header['competitorbrandid']) { ?> selected="selected" <?php } ?>><?php echo $bf['name']; ?></option>
                                            <?php endforeach ?>         
                                        </select>                                           
                                    </div>
                                </div>
                            </div> 

                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Know Product</label>
                                        <select id="cmbKnowProduct" class="form-control select2" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>
                                            <?php foreach ($knowproduct as $kp): ?>           
                                                <option value="<?php echo $kp['id']; ?>" <?php if ($kp['id'] == $header['knowingid']) { ?> selected="selected" <?php } ?>><?php echo $kp['name']; ?></option>
                                            <?php endforeach ?>          
                                        </select>                                           
                                    </div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Taste</label>
                                        <select id="cmbTaste" class="form-control select2" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>> 
                                            <?php foreach ($taste as $ts): ?>           
                                                <option value="<?php echo $ts['id']; ?>" <?php if ($ts['id'] == $header['tasteid']) { ?> selected="selected" <?php } ?>><?php echo $ts['name']; ?></option>
                                            <?php endforeach ?>         
                                        </select>                                           
                                    </div>
                                </div>
                            </div> 

                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Packaging</label>
                                        <select id="cmbPackaging" class="form-control select2" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>
                                            <?php foreach ($packaging as $pc): ?>           
                                                <option value="<?php echo $pc['id']; ?>" <?php if ($pc['id'] == $header['packagingid']) { ?> selected="selected" <?php } ?>><?php echo $pc['name']; ?></option>
                                            <?php endforeach ?>          
                                        </select>                                           
                                    </div>
                                </div>
                                <div class="col-md-6"> 
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="control-label">Outlet Name</label>    
                                            <input type="text" id="txtOutletName" class="form-control" value="<?php print $header['outletname']; ?>" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>  
                                        </div> 
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6"> 
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="control-label">Outlet Address</label>    
                                            <input type="text" id="txtOutletAddress" class="form-control" value="<?php print $header['outletaddress']; ?>" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>  
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-md-6">   
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="control-label">Notes</label>    
                                            <input type="text" id="txtNotes" class="form-control" value="<?php print $header['notes']; ?>" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>  
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
                                    <input type="hidden" class="form-control" id="hidIndex" value="<?php // print count($detail); ?>">	
                                    <input type="hidden" class="form-control" id="hidPriceID" value="<?php // print $header['priceid']; ?>">		                                    
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
    function formatNumber(num) {
      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }

 	function FillSalesOffice()
	{		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>admin/trial/getSalesOffice",
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
			url: "<?php echo base_url();?>admin/trial/getSalesman",
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

    function FillQtyAndPrice(){
        var lookupid = $("#cmbTrialType").val();

        if (lookupid != 2) {
            FillPrice();
            FillTotal();
            $("#txtQty").val();
            $("#txtQty").attr("readonly", false);
        } else {
            $("#txtQty").val(1);
            $("#txtQty").attr("readonly", true);
            $("#txtPrice").val(0);
            $("#txtTotal").val(0);
        }
    }

    function FillTotal()
    {           
        var totalprice = parseInt($("#txtQty").val() * $("#txtPriceAsli").val());
        $("#txtTotalAsli").val(totalprice);
        $("#txtTotal").val(formatNumber(totalprice));
    }

    function FillMaterial()
    {       
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>admin/trial/getMaterial",
            data:  {id: $("#cmbSalesOffice").val()},
            dataType: 'json',
            success: function(data){
                swal(data.length);                                                                       
                var html = '';
                var i;
                for(i=0; i<data.length; i++){
                    html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
                }   
                $('#cmbMaterial').html(html);   
                $('#cmbMaterial').val("-").trigger('change');             
            },
            error: function(jqXHR, textStatus, errorThrown ){
                swal("Error", errorThrown, "error");
            }
        });
    }

    function FillBrandBefore()
    {       
        // swal($("#txtMaterialGroupId").val());
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>admin/trial/getBrandBefore",
            data:  {salesofficeid: $("#cmbSalesOffice").val(),materialgroupid: $("#txtMaterialGroupId").val()},
            dataType: 'json',
            success: function(data){
                swal(data.length);                                                                       
                var html = '';
                var i;
                for(i=0; i<data.length; i++){
                    html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
                }   
                $('#cmbBrandBefore').html(html);   
                $('#cmbBrandBefore').val("-").trigger('change');             
            },
            error: function(jqXHR, textStatus, errorThrown ){
                swal("Error", errorThrown, "error");
            }
        });
    }
    
    function FillPrice()
    {       
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>admin/trial/getPrice",
            data:  {materialid: $("#cmbMaterial").val(), priceid: "Z5", tgl: $("#rdpTanggal").val()}, 
            dataType: 'json',
            success: function(data){                                   
                var price;                                                                          
                if (data.length > 0)
                {
                    price = data[0].value;
                }
                else
                {
                    price = '0';
                }               
                $("#txtPriceAsli").val(price);
                $("#txtPrice").val(formatNumber(price));
                FillTotal();                                                 
            },
            error: function(jqXHR, textStatus, errorThrown ){
                swal("Error", errorThrown, "error");
            }
        });
    }

    function FillMaterialGroup(){      
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>admin/trial/getMaterialGroup",
            data:  {materialid: $("#cmbMaterial").val()}, 
            dataType: 'json',
            success: function(data){                             
                var materialgroup;                                                                          
                if (data.length > 0)
                {
                    materialgroup = data[0].value;
                }
                else
                {
                    materialgroup = '0';
                }    

                // swal(materialgroup);           
                
                $("#txtMaterialGroupId").val(materialgroup);   
                FillBrandBefore();                                       
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
        $("#cmbTrialType").select2();
        $("#cmbMaterial").select2();
        $("#cmbBrandBefore").select2();
        $("#cmbKnowProduct").select2();
        $("#cmbPackaging").select2();
		$("#cmbTaste").select2();

		$("#btnBack").click(function() {						
			location.href="<?php echo base_url();?>admin/trial/list_trial";				
		});	

        <?php if ($header['id'] == '') { ?>
            FillSalesOffice();  
        <?php } else { ?> 
            //FillMaterialGroup();
        <?php } ?>
		
        $("#cmbRegion").change(function() {		
			FillSalesOffice();
		});	
		
		$("#cmbSalesOffice").change(function() {		
			FillSalesman();
            FillMaterial();
		});	

        $("#cmbTrialType").change(function(){
            FillQtyAndPrice(); 
        });

         $("#cmbMaterial").change(function(){
            FillMaterialGroup();
            FillQtyAndPrice(); 
            // FillBrandBefore();
        });

        $("#txtQty").change(function() { 
            //FillTotal(); 
			FillQtyAndPrice(); 
        });

        $("#btnSubmit").click(function() {      
            var trialdate = $("#rdpTanggal").val();
            var salesoffice = $("#cmbSalesOffice").val();
            var region = $("#cmbRegion").val();
            var salesman = $("#cmbSalesman").val();
            var trialtype = $("#cmbTrialType").val();
            var triallocation = $("#txtLocation").val();
            var name = $("#txtName").val();
            var phone = $("#txtPhone").val();
            var age = $("#txtAge").val();
            var material = $("#cmbMaterial").val();
            var qty = $("#txtQty").val();
            var price = $("#txtPriceAsli").val();
            var total = $("#txtTotalAsli").val();
            var brandbefore = $("#cmbBrandBefore").val();
            var knowproduct = $("#cmbKnowProduct").val();
            var taste = $("#cmbTaste").val();
            var packaging = $("#cmbPackaging").val();
            var outletname = $("#txtOutletName").val();
            var outletaddress = $("#txtOutletAddress").val();
            var notes = $("#txtNotes").val();
            
            if (trialdate == ''){ swal('Warning','Please enter Trial Date','warning'); return false; }   
            else if (salesoffice == '-'){ swal('Warning','Please select Sales Office','warning'); return false; }
            else if (region == '-'){ swal('Warning','Please select Region','warning'); return false; }  
            else if (salesman == '-'){ swal('Warning','Please select Salesman','warning'); return false; }   
            else if (trialtype == '-'){ swal('Warning','Please select Trial Type','warning'); return false; }   
            else if (triallocation == ''){ swal('Warning','Please input Location','warning'); return false; }   
            else if (name == ''){ swal('Warning','Please input Name','warning'); return false; }   
            else if (phone == ''){ swal('Warning','Please input Phone','warning'); return false; }   
            else if (age == ''){ swal('Warning','Please input Age','warning'); return false; }   
            else if (material == '-'){ swal('Warning','Please select Material','warning'); return false; }   
            else if (qty == '0'){ swal('Warning','Please input Qty','warning'); return false; }   
            else if (price == '0'){ swal('Warning','Please input Price','warning'); return false; }   
            else if (total == '0'){ swal('Warning','Please input Total','warning'); return false; }   
            else if (brandbefore == '-'){ swal('Warning','Please select Brand Before','warning'); return false; }   
            else if (knowproduct == '-'){ swal('Warning','Please select Know Product','warning'); return false; }   
            else if (taste == '-'){ swal('Warning','Please select Taste','warning'); return false; }   
            else if (packaging == '-'){ swal('Warning','Please select Packaging','warning'); return false; }   
            else if (outletname == ''){ swal('Warning','Please input Outlet Name','warning'); return false; }   
            else if (outletaddress == '-'){ swal('Warning','Please input Outlet Address','warning'); return false; }   
            else if (notes == ''){ swal('Warning','Please input Notes','warning'); return false; }   
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
                    v_data.trialdate = $("#rdpTanggal").val();
                    v_data.salesoffice = $("#cmbSalesOffice").val();
                    v_data.region = $("#cmbRegion").val();
                    v_data.salesman = $("#cmbSalesman").val();
                    v_data.trialtype = $("#cmbTrialType").val();
                    v_data.triallocation = $("#txtLocation").val();
                    v_data.name = $("#txtName").val();
                    v_data.phone = $("#txtPhone").val();
                    v_data.age = $("#txtAge").val();
                    v_data.material = $("#cmbMaterial").val();
                    v_data.qty = $("#txtQty").val();
                    v_data.price = $("#txtPriceAsli").val();
                    v_data.total = $("#txtTotalAsli").val();
                    v_data.brandbefore = $("#cmbBrandBefore").val();
                    v_data.knowproduct = $("#cmbKnowProduct").val();
                    v_data.taste = $("#cmbTaste").val();
                    v_data.packaging = $("#cmbPackaging").val();
                    v_data.outletname = $("#txtOutletName").val();
                    v_data.outletaddress = $("#txtOutletAddress").val();
                    v_data.notes = $("#txtNotes").val();
                                        
                    data["header"]  = JSON.stringify(v_data);
                    
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>admin/trial/save",
                        data: {data:JSON.stringify(data)},
                        dataType: 'json',
                        success: function(jsonData){                        
                            
                            if (jsonData.responseCode=="200"){
                                swal({
                                    title: "Save Success",allowEscapeKey:false,
                                    text: jsonData.responseMsg, type: "success",
                                    confirmButtonText: "OK", closeOnConfirm: true
                                },
                                function () {
                                    location.href="<?php echo base_url();?>admin/trial/list_trial";   
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


	}); 	
 </script>