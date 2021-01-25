<?php 
$header = $data['header']; 
$detail = $data['detail'];
?> 
 <!-- .row -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            
                <div class="panel-heading">    
                    <div class="row">
                        <div class="col-md-8">     
                            MATERIAL Default
                        </div>
                        <div class="col-md-2"> 
                            
                        </div>
                        <div class="col-md-2"> 
                            <button id="btnFilter" class="btn btn-block btn-danger btn-rounded btn-sm"><i class="fa fa-filter"></i> FILTER</button>
                        </div>
                    </div> 
                    
                </div>
                
                <div class="panel-body">
                    <p class="text-muted m-b-30"></p>
                    <div class="row">               
                        <div class="col-md-6">                                    
                            <div class="form-group">
                                <label class="control-label">Region</label>  
                                <select id="cmbRegion" class="form-control select2">
                                    <?php foreach ($region as $rg): ?>      
                                        <option value="<?php echo $rg['id']; ?>"><?php echo $rg['name']; ?></option>
                                    <?php endforeach ?>
                                </select>          
                            </div>
                        </div>
                    </div>
                    <div class="row">               
                        <div class="col-md-6">                                    
                            <div class="form-group">
                                <label class="control-label" >Sales Office</label>
                                <select id="cmbSalesOffice" class="form-control select2">                           
                                </select>                                           
                            </div>
                        </div>            
                    </div>
                </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var arrPOSMType;

    function FillSalesOffice(){       

        //alert('hahahah');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>admin/Materialdefault/getSalesOffice",
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


    

    function FillListData(){
        var region          = $("#cmbRegion").val();
        var salesoffice     = $("#cmbSalesOffice").val();

        location.href="<?php echo base_url();?>admin/Materialdefault/edit_materialdefault"+"/"+region+"/"+salesoffice;
    }   
    
    $(document).ready(function(){   
        
        FillSalesOffice();
        $("#cmbRegion").select2();
        $("#cmbSalesOffice").select2();
              
        $("#cmbRegion").change(function() {     
            FillSalesOffice();
        }); 


        
        $("#cmbSalesOffice").change(function() {        
            // FillSalesman();
        });
             
        $("#btnFilter").click(function() {      
            FillListData();
        });  
    }); 

 </script>
 <style>
    thead input {
        width: 100%;
    }
 </style>