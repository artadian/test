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
                            <p class="text-muted m-b-30 font-13"></p>
                                                                                                                                                       
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="white-box">
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <h3 class="box-title">MASTER DATA BARANG</h3>
                                            </div>                                            
                                            <div class="col-sm-2">
                                                <button id="btnAdd" class="btn btn-block btn-info btn-rounded" <?php if ($mode == 'view') { ?> style="display:none" <?php } ?>><i class="fa fa-plus"></i> TAMBAH BARANG</button>
                                            </div>
                                        </div>
                                        <p class="text-muted m-b-20"></p>
                                        
                                        <div class="table-responsive">
                                            <table id="tblDetailBarang" class="table table-striped color-table primary-table">
                                                <thead>
                                                    <tr>
                                                        <th style="width:30%; text-align: center;">Kode Barang</th>     
                                                        <th style="width:30%; text-align: center;">Nama Barang</th>
                                                        
                                                        <th style="width:14%; text-align: center;">Merk Barang</th>         
                                                        <th style="width:26%; text-align: center;">Nama Supplier</th>           
                                                        <th class="text-nowrap" style="text-align: center;">Action</th>                                                     
                                                    </tr>                                                    
                                                </thead>
                                                <tbody> 
                                                    <?php for ($i=0;$i<$countdetail;$i++) { ?>
                                                    <tr id="trDtBarang<?php print ($i+1); ?>">    
                                                        <td>
                                                             <input type="text" id="txtKode<?php print ($i+1); ?>" class="form-control text-right" value="<?php print $detail[$i]['kode']; ?>">
                                                        </td>
                                                        <td>
                                                             <input type="text" id="txtNama<?php print ($i+1); ?>" class="form-control text-right" value="<?php print $detail[$i]['nama']; ?>">
                                                        </td> 
                                                        
                                                            <input type="text" id="txtMerk<?php print ($i+1); ?>" class="form-control text-right" value="<?php print $detail[$i]['merk']; ?>">
                                                        </td> 
                                                       <td>
                                                            <select id="cmbNamaSupplier<?php print ($i+1); ?>" class="form-control select2" <?php if ($mode == 'view') { ?> disabled="disabled" <?php } ?>> 
                                                            <?php foreach ($tipe as $st): ?>                        
                                                                <option value="<?php echo $st['id']; ?>" <?php if ($st['id'] == $detail[$i]["Supplier"]) { ?> selected="selected" <?php } ?>><?php echo $st['name']; ?></option>
                                                            <?php endforeach ?>
                                                            </select>
                                                        </td> 
                                                        <td>
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
    // var arrMerk;
    var arrSupplier;
    var arrUOM;
    // var arrNamaBarang;
    var arrTipeBarang;
    


    
    function FillTipe()
    {       
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>admin/masterdata/getTipe",

            dataType: 'json',
            success: function(data){                                                                
                var html = '';
                var i;
                for(i=0; i<data.length; i++){
                    html += '<option value='+data[i].id+'>'+data[i].nama+'</option>';
                }  
                arrTipeBarang = html; 
            },
            error: function(jqXHR, textStatus, errorThrown ){
                swal("Error", errorThrown, "error");
            }
        });
    }

    function FillSupplier()
    {       
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>admin/masterdata/getSupplier",

            dataType: 'json',
            success: function(data){                                                                
                var html = '';
                var i;
                for(i=0; i<data.length; i++){
                    html += '<option value='+data[i].kodesupplier+'>'+data[i].nama+'</option>';
                }  
                arrSupplier = html; 
            },
            error: function(jqXHR, textStatus, errorThrown ){
                swal("Error", errorThrown, "error");
            }
        });
    }

    function FillUOM()
    {       
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>admin/masterdata/getUOM",

            dataType: 'json',
            success: function(data){                                                                
                var html = '';
                var i;
                for(i=0; i<data.length; i++){
                    html += '<option value='+data[i].id+'>'+data[i].nama+'</option>';
                }  
                arrUOM = html; 
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
            url: "<?php echo base_url();?>admin/posm/getCustomerByDate",
            data:  {
                id: $("#cmbSalesman").val(),
                date : $("#rdpTanggal").val()
            },
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

    function FillMaterialGroup()
    {       
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>admin/posm/getMaterialGroup",
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

    function FillPOSMType()
    {       
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>admin/posm/getPOSMType",
            data:  {
                salesofficeid: $("#cmbSalesOffice").val(), 
                userid : $("#cmbSalesman").val()
            },
            dataType: 'json',
            success: function(data){     
                if (data.length > 0){
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
                    }
                    arrPOSMType = html;
                }                
            },
            error: function(jqXHR, textStatus, errorThrown ){
                swal("Error", errorThrown, "error");
            }
        });
    }

    function FillStatus()
    {       
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>admin/posm/getLookup",
            data:  {
                lookupkey: 'posm_status'
            },
            dataType: 'json',
            success: function(data){     
                if (data.length > 0){
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
                    }
                    arrStatus = html;
                }                
            },
            error: function(jqXHR, textStatus, errorThrown ){
                swal("Error", errorThrown, "error");
            }
        });
    }

    function FillCondition()
    {       
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>admin/posm/getLookup",
            data:  {
                lookupkey: 'posm_condition'
            },
            dataType: 'json',
            success: function(data){     
                if (data.length > 0){
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
                    }
                    arrCondition = html;
                }                
            },
            error: function(jqXHR, textStatus, errorThrown ){
                swal("Error", errorThrown, "error");
            }
        });
    }
        
    $(document).ready(function(){           
                

        FillTipe();
        FillSupplier();
        FillUOM();
        <?php if ($header['id'] == '') { ?>
            // FillSalesOffice();  
        <?php } ?> 

        $("#btnBack").click(function() {                        
            location.href="<?php echo base_url();?>admin/posm/list_posm";               
        });         
                
        $("#btnSubmit").click(function() {  
            var rowCount = $('#tblDetailBarang tr').length;           

            
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
                    data  = TableData;

                    
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>admin/masterdata/savebarang",
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
                                        location.href="<?php echo base_url();?>admin/masterdata/list_barang";       
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
                           
            
            
        });         
                
        function storeTblValues()
        {
            var TableData = new Array();
            
            $('#tblDetailBarang tbody tr').each(function(row, tr){
                TableData[row]={
                    "kode" : $(tr).find('td:eq(0) input[type="text"]').val(),
                    "nama" :  $(tr).find('td:eq(1) input[type="text"]').val(),                  
                    "merk" : $(tr).find('td:eq(2) input[type="text"]').val(),
                    "supplier" : $(tr).find('td:eq(3)').find('option:selected').val(),    
                           
                }    
            }); 
            console.log(TableData);                 
            return TableData;
        }   
        $("#cmbRegion").change(function() {     
            FillSalesOffice();
        }); 
        
        $("#cmbSalesOffice").change(function() {        
            FillSalesman();
        });

        <?php for ($i=0;$i<count((array)$detail);$i++) { ?> 
        // console.log(idx);
        $("#cmbStatus<?php print ($i+1); ?>").change(function() {       
            
            FillCondition();
            if ($("#cmbStatus<?php print ($i+1); ?>").val() == '1'){
                $("#txtQty<?php print ($i+1); ?>").removeAttr("readonly", true);

                $("#cmbCondition<?php print ($i+1); ?>").attr("disabled", "disabled");
                $("#cmbCondition<?php print ($i+1); ?>").val("-");

                $("#txtNotes<?php print ($i+1); ?>").attr("readonly", true);
                $("#txtNotes<?php print ($i+1); ?>").val("");
            } else {
                
                $("#txtQty<?php print ($i+1); ?>").attr("readonly", true);
                $("#txtQty<?php print ($i+1); ?>").val("0");

                $("#cmbCondition<?php print ($i+1); ?>").removeAttr("disabled", "disabled");
                $("#txtNotes<?php print ($i+1); ?>").removeAttr("readonly", true);
            }
        });
        if ($("#cmbStatus<?php print ($i+1); ?>").val() == '1'){
            $("#txtQty<?php print ($i+1); ?>").removeAttr("readonly", true);
            $("#cmbCondition<?php print ($i+1); ?>").attr("disabled", "disabled");
            $("#txtNotes<?php print ($i+1); ?>").attr("readonly", true);
        }else {
            $("#txtQty<?php print ($i+1); ?>").attr("readonly", true);
            $("#cmbCondition<?php print ($i+1); ?>").removeAttr("disabled", "disabled");
            $("#txtNotes<?php print ($i+1); ?>").removeAttr("readonly", true);
        }
        <?php } ?> 
        
        $("#cmbSalesman").change(function() {       
            FillCustomer();
            FillMaterialGroup();
            
            if ($("#cmbSalesOffice").val() != "-" && $("#cmbSalesman").val() != "-"){
                FillPOSMType();
                FillStatus();
                FillCondition();
            } else {
                return false;
            }
        }); 

        $("#tblDetailBarang").on('click','.btnDel',function(){
            $(this).closest('tr').remove();         
        }); 

        $("#btnAdd").click(function() { 
            
                var idx = parseInt($("#hidIndex").val()) + 1;                   
                $("#tblDetailBarang tbody").append(
                    '<tr id="trDtBarang' + idx +'">' +                   
                    '<td>' +
                        '<input type="text" id="txtKode' + idx +'" class="form-control text-right" value="">' +   
                    '</td>' + 
                    '<td>' +
                         '<input type="text" id="txtNama' + idx +'" class="form-control text-right" value="">' +    
                    '</td>' + 
                    
                    '<td>' +
                        '<input type="text" id="txtMerk' + idx +'" class="form-control text-right" value="">' +   
                    '</td>' +   
                    '<td>' +
                        '<select id="cmbNamaSupplier' + idx +'" class="form-control select2">' + arrSupplier + '</select>' +   
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
    });     
 </script>