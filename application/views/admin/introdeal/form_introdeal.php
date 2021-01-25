 <?php 
$header = $data['header']; 
// print_r($header['regionid']); exit();
?>
 <!-- .row -->
 				<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box p-l-20 p-r-20">
                            <h3 class="box-title m-b-0"><?php print $page_title; ?></h3>
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
                                        <label class="control-label">Material</label>                               
                                        <select id="cmbMaterial" class="form-control select2" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>
                                            <?php foreach ($material as $m): ?>                                         
                                                <option value="<?php echo $m['id']; ?>" <?php if ($m['id'] == $header['materialid']) { ?> selected="selected" <?php } ?>><?php echo $m['name']; ?></option>
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
                                        <label class="control-label">Date</label>  
                                        <div class="input-daterange input-group" id="date-range"> 
                                            <input class="form-control" type="date" id="rdpTglAwal" value="<?php if ($header['id']==0) { print date("Y-m-d"); } else { print $header['startdate'];} ?>" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>
                                            <span class="input-group-addon bg-info b-0 text-white">to</span>
                                            <input class="form-control" type="date" id="rdpTglAkhir" value="<?php if ($header['id']==0) { print date("Y-m-d"); } else { print $header['enddate'];} ?>" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="control-label">Qty Order</label>    
                                            <input type="text" id="txtQtyOrder" class="form-control" value="<?php print $header['qtyorder']; ?>" placeholder="0" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>                                    
                                        </div>                                    
                                    </div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="control-label">Qty Bonus</label>    
                                            <input type="text" id="txtQtyBonus" class="form-control" value="<?php print $header['qtybonus']; ?>" placeholder="0" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>                                    
                                        </div>                                    
                                    </div>
                                </div>
                            </div>  
                            <br>                                      
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
    function FillSalesOffice()
    {       
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>admin/introdeal/getSalesOffice",
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

    function FillMaterial()
    {       
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>admin/introdeal/getMaterial",
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

 	$(document).ready(function(){
        $("#cmbRegion").select2();
        $("#cmbSalesOffice").select2();
        $("#cmbMaterial").select2();

        <?php if ($header['id'] == '') { ?>
            FillSalesOffice();  
        <?php } ?>
        
        $("#cmbRegion").change(function() {     
            FillSalesOffice();
        }); 

        $("#cmbSalesOffice").change(function() {     
            FillMaterial();
        }); 

		$("#btnBack").click(function() {						
			location.href="<?php echo base_url();?>admin/introdeal/list_introdeal";				
		});	

        $("#btnSubmit").click(function() {            
            var salesofficeid = $("#cmbSalesOffice").val();
            var materialid = $("#cmbMaterial").val();
            var startdate = $("#rdpTglAwal").val();
            var enddate = $("#rdpTglAkhir").val();
            var qtyorder = $("#txtQtyOrder").val();
            var qtybonus = $("#txtQtyBonus").val();
            
            if (materialid == '-'){ swal('Warning','Please select Material','warning'); return false; } 
            else if (salesofficeid == '-'){ swal('Warning','Please select Sales ','warning'); return false; } 
            else if (startdate == ''){ swal('Warning','Please input Start Date ','warning'); return false; }
            else if (enddate == ''){ swal('Warning','Please input End Date ','warning'); return false; }  
            else if (qtyorder == ''){ swal('Warning','Please input Qty Order ','warning'); return false; }  
            else if (qtybonus == ''){ swal('Warning','Please input Qty Bonus ','warning'); return false; }  
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
                    v_data.materialid = $("#cmbMaterial").val();               
                    v_data.salesofficeid = $("#cmbSalesOffice").val();                       
                    v_data.startdate = $("#rdpTglAwal").val();                       
                    v_data.enddate = $("#rdpTglAkhir").val();                       
                    v_data.qtyorder = $("#txtQtyOrder").val();                       
                    v_data.qtybonus = $("#txtQtyBonus").val();                       
                    data["header"]  = JSON.stringify(v_data);
                    
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>admin/introdeal/save",
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
                                        location.href="<?php echo base_url();?>admin/introdeal/list_introdeal";       
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