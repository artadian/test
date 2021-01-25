 <?php 
$header = $data['header']; 
?>
 <!-- .row -->
 				<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box p-l-20 p-r-20">
                            <h3 class="box-title m-b-0"><?php print $page_title; ?></h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Competitor</label>
                                        <select id="cmbCompetitor" class="form-control select2" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>
                                            <?php foreach ($competitor as $ct): ?>                                                                  
                                                <option value="<?php echo $ct['id']; ?>" <?php if ($ct['id'] == $header['competitorid']) { ?> selected="selected" <?php } ?>><?php echo $ct['name']; ?></option>
                                            <?php endforeach ?>
                                        </select>   
                                    </div>
                                </div>
                                <div class="col-md-6"> 
                                    <div class="form-group"> 
                                        <label class="control-label">Brand</label>                               
                                        <input type="text" id="txtBrand" class="form-control" value="<?php print $header['brand']; ?>" placeholder="Name" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>  
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
 	$(document).ready(function(){	
		$("#btnBack").click(function() {						
			location.href="<?php echo base_url();?>admin/brandcompetitor/list_brand_competitor";				
		});	

        $("#btnSubmit").click(function() {             
            var name = $("#txtName").val();
            var competitor = $("#cmbCompetitor").val();
            
            if (name == ''){ swal('Warning','Please enter Name','warning'); return false; }  
            else if (competitor == '-'){ swal('Warning','Please select Competitor','warning'); return false; } 
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
                    v_data.name = $("#txtBrand").val();               
                    v_data.competitor = $("#cmbCompetitor").val();               
                    data["header"]  = JSON.stringify(v_data);
                    
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>admin/brandcompetitor/save",
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
                                        location.href="<?php echo base_url();?>admin/brandcompetitor/list_brand_competitor";       
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