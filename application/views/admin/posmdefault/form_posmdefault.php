 <?php 
$header = $data['header']; 
$detail = count($getform);

?>
 <!-- .row -->
<div class="row">
   <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading">    
                <div class="row">
                    <div class="col-md-8">     
                        POSM Default
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
                                    <option value="<?php echo $rg['id']; ?>" <?php if ($rg['id'] == $getregionn) { ?> selected="selected" <?php } ?>><?php echo $rg['name']; ?></option>
                                <?php endforeach ?>
                            </select>             
                        </div>
                    </div>
                </div>
                <div class="row" id="SOC">               
                    <div class="col-md-6">                                    
                        <div class="form-group">
                            <label class="control-label" >Sales Office</label>
                            <select id="cmbSalesOffice" class="form-control select2">
                                <?php foreach ($salesoffice as $so): ?>              
                                    <option value="<?php echo $so['id']; ?>" <?php if ($so['id'] == $getsalesofficee) { ?> selected="selected" <?php } ?>><?php echo $so['name']; ?></option>
                                <?php endforeach ?>
                            </select>                                         
                        </div>
                    </div>            
                </div>
                 <div class="row">               
                    <div class="col-md-6">                                    
                        <div class="form-group">
                            <label class="control-label">Role</label>
                             <select id="cmbRole" class="form-control select2">
                                <?php foreach ($role as $rl): ?>              
                                    <option value="<?php echo $rl['id']; ?>" <?php if ($rl['id'] == $getrolee) { ?> selected="selected" <?php } ?>><?php echo $rl['name']; ?></option>
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
                                    <h3 class="box-title">LIST POSM DEFAULT</h3>
                                </div>                                            
                                <div class="col-sm-2">
                                    <button id="btnAdd" class="btn btn-block btn-info btn-rounded" ><i class="fa fa-plus"></i> ADD</button>
                                </div>
                            </div>
                            <p class="text-muted m-b-20"></p>
                            
                            <div class="table-responsive">
                                <table id="tblMaterial" class="table table-striped color-table primary-table">
                                    <thead>
                                        <tr>              
                                            <th style="width:90%">POSM</th> 
                                            <th style="width:20%; display:none">ID</th>       
                                            <th class="text-nowrap">Action</th>                                                            
                                        </tr>                                                    
                                    </thead>
                                    <tbody> 
                                    <?php if(count($getform) <= 0){?>     
                                    <?php }else{?>
                                    <?php $i=0;foreach ($getform as $det):?>
                                        <tr id="trMat<?php print ($i+1); ?>">
                                            <td>
                                                <select id="cmbPosmType<?php print ($i+1); ?>" class="form-control select2">
                                                    <?php foreach ($getposmtype as $po): ?>     
                                                        <option value="<?php echo $po['id']; ?>" <?php if ($po['id'] == $det['posmtypeid']) { ?> selected="selected" <?php } ?>><?php echo $po['name']; ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </td> 
                                            <td style="display:none">
                                                <input type="text" id="txtID<?php print ($i+1); ?>" class="form-control" disabled="disabled" value="<?php echo $det['id']; ?>">
                                            </td>   
                                            <td class="text-nowrap">
                                                <a class="btnDel" href="#" onclick="return false;" data-toggle="tooltip" data-original-title="Delete"> <button type="button" class="btn btn-danger btn-circle btn-xs"><i class="fa fa-close"></i></button> </a>
                                            </td>
                                        </tr> 
                                    <?php $i++;endforeach ?>
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
                    </div>              
                    <div class="col-sm-8"> 
                        <input type="hidden" class="form-control" id="hidIndex" value="<?php print $detail; ?>">                                        
                    </div>
                    <div class="col-sm-2">                                    
                        <button id="btnSubmit" class="btn btn-block btn-success btn-rounded">SUBMIT</button>
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
            url: "<?php echo base_url();?>admin/Posmdefault/getSalesOffice",
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


    function FillRole(){   
    //alert('hhahhahah');   
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>admin/Posmdefault/getRole",
            data:  {},
            dataType: 'json',
            success: function(data){                                                                
                var html = '';
                var i;
                for(i=0; i<data.length; i++){
                    html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
                }
                $('#cmbRole').html(html);    
                $('#cmbRole').val("-").trigger('change');    
            },
            error: function(jqXHR, textStatus, errorThrown ){
                swal("Error", errorThrown, "error");
            }
        });
    } 

    function FillPosmType(){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>admin/Posmdefault/getPosmType",
            data:  {},
            dataType: 'json',
            success: function(data){
                var html = '';
                var i;
                for(i=0; i<data.length; i++){
                    html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
                }
                arrPOSMType = html; 
                //alert(arrPOSMType); 
            },
            error: function(jqXHR, textStatus, errorThrown ){
                swal("Error", errorThrown, "error");
            }
        });
    }

    function FillListData(){
        var region          = $("#cmbRegion").val();
        var salesoffice     = $("#cmbSalesOffice").val();
        var role            = $("#cmbRole").val();

        location.href="<?php echo base_url();?>admin/Posmdefault/edit_posmdefault"+"/"+region+"/"+salesoffice+"/"+role; 
    }   
    
    
    $("#cmbRegion").change(function() { 
         
            FillSalesOffice();
        }); 

    $(document).ready(function(){   
        
        
        $("#cmbRegion").select2();
        $("#cmbSalesOffice").select2();
        $("#cmbRole").select2();
        $("#cmbPosmType").select2();
              
        

        $("#btnFilter").click(function() {      
            FillListData();
        });

        $("#cmbRegion").change(function() { 
         
            FillSalesOffice();
        }); 

        $("#btnAdd").click(function() {             
            if ($("#cmbRole").val() == '-')
            {
                swal('Warning','Please select Role','warning');             
                return false;
            }
            else
            {
                var idx = parseInt($("#hidIndex").val()) + 1;                   
                $("#tblMaterial tbody").append(
                    '<tr id="trMat' + idx +'">' +                   
                    '<td>' +
                        '<select id="cmbPosmType' + idx +'" class="form-control select2">' + arrPOSMType + '</select>' +   
                    '</td>' + 
                    '<td style="display:none">' +
                       '<input type="text" id="txtID' + idx +'" value="0" class="form-control" disabled="disabled">'+ 
                    '</td>' +
                    '<td class="text-nowrap">' +
                        '<a class="btnDel" href="#" onclick="return false;" data-toggle="tooltip" data-original-title="Delete"> <button type="button" class="btn btn-danger btn-circle btn-xs"><i class="fa fa-close"></i></button> </a>' +
                    '</td>' +
                    '</tr>'
                );
                $("#hidIndex").val(idx);  
                
            }                       
        }); 
        $("#tblMaterial").on('click','.btnDel',function(){
            $(this).closest('tr').remove();       
        });

        FillPosmType();
    }); 

    $("#btnSubmit").click(function() {  
            var rowCount = $('#tblMaterial tr').length; 
            var SalesOffice = $("#cmbSalesOffice").val(); 
            var Role = $("#cmbRole").val();        
            
            var cekMatDouble = true;   
			var materialDouble = '';     
            for (var i=1;i<rowCount;i++)
            {
                var materialid = $('#tblMaterial').find("tr:eq("+ i +")").find("td:eq(0)").find('option:selected').val();              
                if (materialid != '-')
                {
                    if (i < rowCount-1)
                    {
                        var ok = false;
                        for (var j=(i+1);j<rowCount;j++)
                        {
                            var materialcek = $('#tblMaterial').find("tr:eq("+ j +")").find("td:eq(0)").find('option:selected').val(); 
                            if (materialcek != '-')
                            {
                                if (materialid == materialcek)
                                {                                               
                                    ok = true;                                  
                                    break;
                                }           
                            }                                   
                        }
                        if (ok == true)
                        {
                            cekMatDouble = false;
							materialDouble = materialid;
                            break;
                        }       
                    }                   
                }                   
            }
            
            var barisKosong = '';
            for (var i=1;i<rowCount;i++)
            {
                var materialid = $('#tblMaterial').find("tr:eq("+ i +")").find("td:eq(0)").find('option:selected').val();
                if (materialid == '-')
                {
                    barisKosong = i;
                    break;
                }
            }
            
              
            if (rowCount == 1)
            {
                swal('Warning','Please add material','warning');                
                return false;
            }       
            else if (cekMatDouble == false)
            {
                swal('Warning','Double material no ' + materialDouble,'warning');               
                return false;
            } 
            else if (barisKosong != '')
            {
                swal('Warning','Please enter Material at row ' + barisKosong,'warning');                
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
                    v_data.salesoffice = $("#cmbSalesOffice").val();                
                    v_data.role = $("#cmbRole").val();

                                        
                    data["header"]  = JSON.stringify(v_data);
                    
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>admin/Posmdefault/save",
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
                                        location.href="<?php echo base_url();?>admin/Posmdefault/list_posm_default";     
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
            
                $('#tblMaterial tbody tr').each(function(row, tr){
                    TableData[row]={
                        "posmtypeid" : $(tr).find('td:eq(0)').find('option:selected').val(),
                        "id" : $(tr).find('td:eq(1) input[type="text"]').val(),               
                    }    
                });   
                console.log(TableData);                 
                return TableData;
            }

 </script>
 <style>
    thead input {
        width: 100%;
    }
 </style>
 
    