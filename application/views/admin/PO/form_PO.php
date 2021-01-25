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
            <h3 class="box-title m-b-0"><?php print $page_title; ?></h3>
            <p class="text-muted m-b-30 font-13"></p>
            <div class="row">
                <div class="col-md-6">  
                    <div class="form-group">
                        <label class="control-label">NO Purchase Order</label>
                        <input class="form-control" type="text" id="txtnomor" value="<?php if($header['id'] > 0 && $mode == 'view' || $mode == 'edit'){ echo $header["code"];} ?>" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>                  
                    </div>  
                </div>
                <div class="col-md-6">                                    
                    <div class="form-group">
                        <label class="control-label">Supplier</label>
                        <select id="cmbSupplier" class="form-control select2" <?php if ($header['kodesupplier'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>
                            <?php foreach ($supplier as $sup): ?>                                                                  
                                <option value="<?php echo $sup['kodesupplier']; ?>" <?php if ($sup['kodesupplier'] == $header['kodesupplier']) { ?> selected="selected" <?php } ?>><?php echo $sup['nama']; ?></option>
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
                                                        <th style="width:14%; text-align: center;">QTY</th>  
                                                        <th style="width:14%; text-align: center;">Satuan</th>         
                                                        <th class="text-nowrap" style="text-align: center;">Action</th>                                                     
                                                    </tr>                                                    
                                                </thead>
                                                <tbody> 
                                                    <?php for ($i=0;$i<$countdetail;$i++) { ?>
                                                    <tr id="trDtBarang<?php print ($i+1); ?>">    
                                                        <td>
                                                            <select id="cmbBarang<?php print ($i+1); ?>" class="form-control select2" <?php if ($mode == 'view') { ?> disabled="disabled" <?php } ?>> 
                                                            <?php foreach ($tipe as $st): ?>                        
                                                                <option value="<?php echo $st['id']; ?>" <?php if ($st['id'] == $detail[$i]["Supplier"]) { ?> selected="selected" <?php } ?>><?php echo $st['name']; ?></option>
                                                            <?php endforeach ?>
                                                            </select>
                                                        </td>  
                                                        <td>
                                                             <input type="text" id="txtNama<?php print ($i+1); ?>" class="form-control text-right" value="<?php print $detail[$i]['nama']; ?>">
                                                        </td> 
      
                                                        <td>
                                                            <input type="text" id="txtMerk<?php print ($i+1); ?>" class="form-control text-right" value="<?php print $detail[$i]['merk']; ?>">
                                                        </td>
                                                        <td>
                                                            <input type="text" id="txtQTY<?php print ($i+1); ?>" class="form-control text-right" value="<?php print $detail[$i]['merk']; ?>">
                                                        </td>
                                                        <td>
                                                            <select id="cmbSatuan<?php print ($i+1); ?>" class="form-control select2" <?php if ($mode == 'view') { ?> disabled="disabled" <?php } ?>> 
                                                            <?php foreach ($tipe as $st): ?>                        
                                                                <option value="<?php echo $st['id']; ?>" <?php if ($st['id'] == $detail[$i]["Supplier"]) { ?> selected="selected" <?php } ?>><?php echo $st['name']; ?></option>
                                                            <?php endforeach ?>
                                                            </select>
                                                        </td>   
                                                       
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

            <br>                                      
            <div class="row">
                <div class="col-sm-2">
                    <button id="btnBack" class="btn btn-block btn-danger btn-rounded">BACK</button>
                </div>              
                <div class="col-sm-8">
                    <input type="hidden" class="form-control" id="hidIndex" value="<?php print count($detail); ?>">                                           
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
 var arrTipeBarang;
 var arrUOM;
 var arrBarang;

function FillMaterial()
    {       
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>admin/transaksi/getMaterial",
            data:  {id: $("#cmbSupplier").val()},
            dataType: 'json',
            success: function(data){                                                                                
                var html = '';
                var i;
                for(i=0; i<data.length; i++){
                    html += '<option value='+data[i].kode+'>'+data[i].nama+'</option>';
                }
                arrBarang = html;             
            },
            error: function(jqXHR, textStatus, errorThrown ){
                swal("Error", errorThrown, "error");
            }
        });
    } 
function FillMaterialDetail(idx)
    {       
        // console.log($("#cmbBarang" + idx).val());
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>admin/transaksi/getMaterialDetail",
            data:  {idbarang: $("#cmbBarang" + idx).val()}, 
            dataType: 'json',
            success: function(data){                                                                                
                             // console.log(data[0]['nama']);
                $("#txtNama" + idx).val(data[0]['nama']);
                $("#txtMerk" + idx).val(data[0]['merk']);
                // FillBalSlofPac(idx);                                                    
            },
            error: function(jqXHR, textStatus, errorThrown ){
                swal("Error", errorThrown, "error");
            }
        });
    }

 function storeTblValues()
        {
            var TableData = new Array();
            
            $('#tblDetailBarang tbody tr').each(function(row, tr){
                TableData[row]={
                    "kode" : $(tr).find('td:eq(0)').find('option:selected').val(),
                    "nama" :  $(tr).find('td:eq(1) input[type="text"]').val(),                  
                    "merk" : $(tr).find('td:eq(2) input[type="text"]').val(),    
                    "qty" : $(tr).find('td:eq(3) input[type="text"]').val(), 
                    "satuan" : $(tr).find('td:eq(4)').find('option:selected').val()     
                }    
            }); 
            // console.log(TableData);                 
            return TableData;
        }
        $("#tblDetailBarang").on('click','.btnDel',function(){
            $(this).closest('tr').remove();         
        }); 
        $("#btnAdd").click(function() { 
            
                var idx = parseInt($("#hidIndex").val()) + 1;                   
                $("#tblDetailBarang tbody").append(
                    '<tr id="trDtBarang' + idx +'">' +                   
                    '<td>' +
                        '<select id="cmbBarang' + idx +'" class="form-control select2">' + arrBarang + '</select>' +   
                    '</td>' +
                    '<td>' +
                         '<input type="text" id="txtNama' + idx +'" class="form-control text-right" value="">' +    
                    '</td>' + 

                    '<td>' +
                        '<input type="text" id="txtMerk' + idx +'" class="form-control text-right" value="">' +   
                    '</td>' +     
                    '<td>' +
                        '<input type="text" id="txtQTY' + idx +'" class="form-control text-right" value="">' +   
                    '</td>' +
                    '<td>' +
                        '<select id="cmbSatuan' + idx +'" class="form-control select2">' + arrUOM + '</select>' +   
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
                $("#cmbBarang" + idx).change(function() {     

                   FillMaterialDetail(idx);                                                
                });
                                       
        });
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
    $(document).ready(function(){ 
        $("#cmbSupplier").select2();
  
        $("#cmbSupplier").change(function() {     
        FillMaterial();
        }); 



        FillUOM();
        
        $("#cmbSupplier").change(function() {       
            // FillPriceID();          
            $('#tblDetailBarang tbody').html('');           
            // FillTotal();
        }); 
        $("#btnSubmit").click(function() {             
            var noPO = $("#txtnomor").val();

            
            if (noPO == ''){ swal('Warning','Please enter PO Number','warning'); return false; }  
     
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
                    v_data.nomor = $("#txtnomor").val();              
                    v_data.kodesupplier = $("#cmbSupplier").val();           
                    data["header"]  = JSON.stringify(v_data);
                    // if (TableData == []) {swal('Warning','Please enter Material','warning'); return false;};
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>admin/transaksi/savePO",
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
                                        location.href="<?php echo base_url();?>admin/transaksi/list_PO";       
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