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
                        <label class="control-label">Name</label>
                        <input class="form-control" type="text" id="txtName" value="<?php if($header['id'] > 0 && $mode == 'view' || $mode == 'edit'){ echo $header["name"];} ?>" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>                  
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Code</label>
                        <input class="form-control" type="text" id="txtCode" value="<?php if($header['id'] > 0 && $mode == 'view' || $mode == 'edit'){ echo $header["code"];} ?>" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>                  
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Type</label>
                        <select id="cmbType" class="form-control select2" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>
                            <?php foreach ($salesofficetype as $rg): ?>                                                                  
                                <option value="<?php echo $rg['id']; ?>" <?php if ($rg['id'] == $header['type']) { ?> selected="selected" <?php } ?>><?php echo $rg['name']; ?></option>
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
    $(document).ready(function(){   
        $("#cmbRegion").select2();
        
        $("#btnBack").click(function() {                        
            location.href="<?php echo base_url();?>admin/salesoffice/list_salesoffice";               
        }); 

        $("#btnSubmit").click(function() { 

            var region  = $("#cmbRegion").val();            
            var name    = $("#txtName").val();
            var code    = $("#txtCode").val();
            var type    = $("#cmbType").val();
            //alert(type);


            
            if (region == ''){
                swal('Warning','Please select region','warning');               
                return false;
            }else if (name == ''){
                swal('Warning','Please enter name','warning');             
                return false;
            }else if (code == ''){
                swal('Warning','Please enter code','warning');             
                return false;
            }else if (type == ''){
                swal('Warning','Please select type','warning');             
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
                    v_data.region = $("#cmbRegion").val();
                    v_data.name = $("#txtName").val();
                    v_data.code = $("#txtCode").val();
                    v_data.type = $("#cmbType").val();
                                         
                    data["header"]  = JSON.stringify(v_data);
                    
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>admin/salesoffice/save",
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
                                        location.href="<?php echo base_url();?>admin/salesoffice/list_salesoffice";       
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
 
