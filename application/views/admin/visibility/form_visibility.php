 <?php 
 $header = $data['header']; 
 $detail = $data['detail'];
// print_r($header); exit();
 ?>
 <!-- .row -->
 <div class="row">
    <div class="col-sm-12">
        <div class="white-box p-l-20 p-r-20">
            <h3 class="box-title m-b-0"><?php print $page_title; ?></h3>
            <div class="row">
                <div class="col-md-6"> 
                    <div class="form-group">
                        <label class="control-label">Visibility Date</label>
                        <input class="form-control" type="date" id="rdpTanggal" value="<?php if ($header['id']==0) { print date("Y-m-d"); } else { print $header['visibilitydate'];} ?>" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>                        
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

                </div>
            </div>  
            <br> 
            <div class="row">
                <div class="col-sm-9">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-sm-10">
                                <h3 class="box-title">LIST MATERIAL</h3>
                            </div>                                            
                            <div class="col-sm-2">
                                <button id="btnAdd" class="btn btn-block btn-info btn-rounded" <?php if ($mode == 'view' || $mode == 'edit') { ?> style="display:none" <?php } ?>><i class="fa fa-plus"></i> ADD</button>
                            </div>
                        </div>
                        <p class="text-muted m-b-20"></p>

                        <div class="table-responsive">
                            <table id="tblMaterial" class="table table-striped color-table primary-table">
                                <thead>
                                    <tr>  
                                        <th class="text-nowrap" style="display:none;width:15%">Action</th> 
                                        <th style="width:15%; display:none">Material ID</th>  
                                        <th style="width:55%">Material</th>  
                                        <th style="width:15%">PAC</th>
                                        <th style="display: none;">detail ID</th>

                                    </tr>                                                    
                                </thead>
                                <tbody>         
                                    <?php if (!empty($detail))
                                    for ($i=0;$i<count($detail);$i++) {  ?>
                                        <tr id="trMat<?php print ($i+1); ?>">         
                                            <td class="text-nowrap" style="display:none">
                                                <a class="btnDel" href="#" onclick="return false;" data-toggle="tooltip" data-original-title="Delete"> <button type="button" class="btn btn-danger btn-circle btn-xs"><i class="fa fa-close"></i></button> </a>
                                            </td>          
                                            <td style="display:none">
                                                <input type="text" id="txtMaterialID<?php print ($i+1); ?>" class="form-control" value="<?php print $detail[$i]['materialid']; ?>" style="display:none">
                                            </td>
                                            <td>
                                                <input type="text" id="txtMaterial<?php print ($i+1); ?>" class="form-control" value="<?php print $detail[$i]['material']; ?>" disabled="disabled">
                                            </td>                 
                                            <td>
                                                <input type="text" id="txtPac<?php print ($i+1); ?>" class="form-control text-right" value="<?php print $detail[$i]['pac']; ?>">
                                            </td>
                                            <td style="display: none;">
                                                <input type="text" id="txtID<?php print ($i+1); ?>" class="form-control" disabled="disabled" value="<?php print $detail[$i]['detailID']; ?>">
                                            </td> 
                                        </tr>                                                   
                                    <?php } ?>
                                </tbody>                                       
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
                 <input type="hidden" class="form-control" id="hidIndex" value="<?php if(!empty($detail)){ print count($detail); }?>">		                                    
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
    var arrMaterial;

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function checkMaxPac(val,idx) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>admin/visibility/getPacMax",
            data:  {customerno: $("#cmbCustomer").val(), materialid: $("#cmbMaterial" + idx).val()},
            dataType: 'json',
            success: function(data){  
                var maxvalue;
                if (data.length > 0) {
                    maxvalue = parseInt(data[0].maxvalue)
                    if(val>maxvalue){
                        swal('Warning','Amount exceeds the maximum limit (' + maxvalue + ' pac)!','warning'); 
                        $("#txtPac" + idx).val(0);
                        return false; 
                    }
                }                            
            },
            error: function(jqXHR, textStatus, errorThrown ){
                swal("Error", errorThrown, "error");
            }
        });
    }

    function FillSalesOffice()
    {       
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>admin/visibility/getSalesOffice",
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
            url: "<?php echo base_url();?>admin/visibility/getSalesman",
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

    function FillCustomerUser()
    {       
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>admin/visibility/getCustomerUser",
            data:  {userid: $("#cmbSalesman").val(), date : $("#rdpTanggal").val()},
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

    // function FillMaterial()
    // {       
    //     $.ajax({
    //         type: "POST",
    //         url: "<?php echo base_url();?>admin/visibility/getMaterial",
    //         data:  {id: $("#cmbSalesOffice").val()},
    //         dataType: 'json',
    //         success: function(data){                                                                                
    //             var html = '';
    //             var i;
    //             for(i=0; i<data.length; i++){
    //                 html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
    //                 // html += data[i].name;
    //                 // arrMaterial = html;
    //             }
    //             // arrMaterial = html;  

    //             $('#cmbMaterialH').html(html);   
    //             $('#cmbMaterialH').val("-").trigger('change');       
    //         },
    //         error: function(jqXHR, textStatus, errorThrown ){
    //             swal("Error", errorThrown, "error");
    //         }
    //     });
    // }

    $(document).ready(function(){
        $("#cmbRegion").select2();
        $("#cmbSalesOffice").select2();
        $("#cmbCustomer").select2();
        $("#cmbSalesman").select2();
        $("#cmbMaterialH").select2();
        // FillMaterial(); 
        <?php if ($header['id'] == '') { ?>
            FillSalesOffice(); 
        <?php } ?>
        
        $("#cmbRegion").change(function() {     
            FillSalesOffice();
        }); 

        $("#cmbSalesOffice").change(function() {     
            FillSalesman();
            // FillMaterial();
            // $("#tblMaterial tbody").html(""); 
            // $("#btnAdd").show(); 
        }); 

        $("#cmbSalesman").change(function() {     
            FillCustomerUser();
            $("#tblMaterial tbody").html(""); 
            $("#btnAdd").show(); 
        }); 

        $("#btnBack").click(function() {						
           location.href="<?php echo base_url();?>admin/visibility/list_visibility";				
       });

        $("#btnSubmit").click(function() {       
            var tanggal = $("#rdpTanggal").val();
            var regionid = $("#cmbRegion").val();
            var salesofficeid = $("#cmbSalesOffice").val();
            var salesmanid = $("#cmbSalesman").val();
            var customerid = $("#cmbCustomer").val();

            var rowCount = $('#tblMaterial tr').length;     

            if (tanggal == '-'){ swal('Warning','Please enter visibility date','warning'); return false; }   
            else if (regionid == '-'){ swal('Warning','Please select region','warning'); return false; } 
            else if (salesofficeid == '-'){ swal('Warning','Please select sales office','warning'); return false; }  
            else if (salesmanid == '-'){ swal('Warning','Please select salesman','warning'); return false; }  
            else if (customerid == '-'){ swal('Warning','Please select customer','warning'); return false; }  
            else if (rowCount <= 1){ swal('Warning','Please add material','warning'); return false; }   
            else
            {
                swal(
                {
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
                    v_data.tanggal = $("#rdpTanggal").val();
                    v_data.regionid = $("#cmbRegion").val();
                    v_data.salesofficeid = $("#cmbSalesOffice").val();
                    v_data.salesmanid = $("#cmbSalesman").val();
                    v_data.customerid = $("#cmbCustomer").val();

                    data["header"]  = JSON.stringify(v_data);

                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>admin/visibility/save",
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
                                    location.href="<?php echo base_url();?>admin/visibility/list_visibility";       
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

        // $("#tblMaterial").on('click','.btnDel',function(){
        //     $(this).closest('tr').remove();    
        // }); 

        $("#btnAdd").click(function() {  
            // FillMaterial();   
            $("#tblMaterial tbody").html(""); 
            if ($("#cmbCustomer").val() == '-')
            {
                swal('Warning','Please select Customer','warning');             
                return false;
            }
            else
            { 
                var idx = parseInt($("#hidIndex").val()) + 1;    

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>admin/visibility/getMaterial",
                    data:  {id: $("#cmbSalesOffice").val()},
                    dataType: 'json',
                    success: function(data){                                                                  
                        var html = '';
                        var i;
                        for(i=0; i<data.length; i++){ 
                            $("#tblMaterial tbody").append(
                                '<tr id="trMat' + i +'">' +  
                                '<td class="text-nowrap" style="display:none">' +
                                '<a class="btnDel" href="#" onclick="return false;" data-toggle="tooltip" data-original-title="Delete"> <button type="button" class="btn btn-danger btn-circle btn-xs"><i class="fa fa-close"></i></button> </a>' +
                                '</td>' +                 
                                '<td style="display:none">' +   
                                '<input type="text" id="txtMaterialID' + i +'" class="form-control" value="' + data[i].id + '" disabled="disabled" style="display:none">' +
                                '</td>' + 
                                '<td>' +   
                                '<input type="text" id="txtMaterial' + i +'" class="form-control" value="' + data[i].name + '" disabled="disabled">' +
                                '</td>' +                                                          
                                '<td>' +
                                '<input type="text" id="txtPac' + i +'" class="form-control text-right" value="0">' +
                                '</td>' +
                                '<td style="display:none">' +
                                '<input type="text" id="txtID' + i +'" value="0" class="form-control" disabled="disabled">' +
                                '</td>' +  
                                '</tr>'
                                );
                        }   
                    },
                    error: function(jqXHR, textStatus, errorThrown ){
                        swal("Error", errorThrown, "error");
                    }
                });
                $("#hidIndex").val(idx);
            }                     
        });     

        function storeTblValues()
        {
            var TableData = new Array();

            $('#tblMaterial tbody tr').each(function(row, tr){
                TableData[row]={
                    "materialid" : $(tr).find('td:eq(1) input[type="text"]').val(),           
                    "pac" : $(tr).find('td:eq(3) input[type="text"]').val(),           
                    "detailID" : $(tr).find('td:eq(4) input[type="text"]').val(),           
                }    
            });   
            console.log(TableData);           
            return TableData;
        }

    }); 	
</script>