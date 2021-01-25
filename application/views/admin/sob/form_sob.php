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
                                        <label class="control-label">Material Group</label>                               
                                        <select id="cmbMaterialGroup" class="form-control select2" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>
                                            <?php foreach ($materialgroup as $mg): ?>                                         
                                                <option value="<?php echo $mg['id']; ?>" <?php if ($mg['id'] == $header['materialgroupid']) { ?> selected="selected" <?php } ?>><?php echo $mg['name']; ?></option>
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
                                        <label class="control-label">Brand Competitor</label>                               
                                        <select id="cmbCompetitorBrand" class="form-control select2" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>
                                            <?php foreach ($competitorbrand as $cb): ?>                                
                                                <option value="<?php echo $cb['id']; ?>" <?php if ($cb['id'] == $header['competitorbrandid']) { ?> selected="selected" <?php } ?>><?php echo $cb['name']; ?></option>
                                            <?php endforeach ?>
                                        </select>  
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
            url: "<?php echo base_url();?>admin/sob/getSalesOffice",
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

 	$(document).ready(function(){
        $("#cmbRegion").select2();
        $("#cmbSalesOffice").select2();
        $("#cmbMaterialGroup").select2();
        $("#cmbCompetitorBrand").select2();

        <?php if ($header['id'] == '') { ?>
            FillSalesOffice();  
        <?php } ?>
        
        $("#cmbRegion").change(function() {     
            FillSalesOffice();
        }); 

		$("#btnBack").click(function() {						
			location.href="<?php echo base_url();?>admin/sob/list_sob";				
		});	

        $("#btnSubmit").click(function() {             
            var materialgroupid = $("#cmbMaterialGroup").val();
            var salesofficeid = $("#cmbSalesOffice").val();
            var competitorbrandid = $("#cmbCompetitorBrand").val();
            
            if (materialgroupid == ''){ swal('Warning','Please select Material Group','warning'); return false; } 
            else if (salesofficeid == '-'){ swal('Warning','Please select Sales Office','warning'); return false; }  
            else if (competitorbrandid == '-'){ swal('Warning','Please select Brand Competitor','warning'); return false; }  
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
                    v_data.materialgroupid = $("#cmbMaterialGroup").val();               
                    v_data.salesofficeid = $("#cmbSalesOffice").val();               
                    v_data.competitorbrandid = $("#cmbCompetitorBrand").val();               
                    data["header"]  = JSON.stringify(v_data);
                    
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>admin/sob/save",
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
                                        location.href="<?php echo base_url();?>admin/sob/list_sob";       
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