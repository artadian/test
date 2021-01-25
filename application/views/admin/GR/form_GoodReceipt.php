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
                        <label class="control-label">Kode Supplier</label>                               
                        <input type="text" id="txtKode" class="form-control" value="<?php print $header['kode']; ?>" placeholder="Kode" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>
                    </div>  
                </div>
                <div class="col-md-6"> 
                    <div class="form-group"> 
                        <label class="control-label">Nama Supplier</label>                               
                        <input type="text" id="txtNama" class="form-control" value="<?php print $header['nama']; ?>" placeholder="Nama" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>
                    </div>  
                </div>
            </div>
            <div class="row">
                <div class="col-md-6"> 
                    <div class="form-group"> 
                        <label class="control-label">Alamat</label>                               
                        <input type="text" id="txtAlamat" class="form-control" value="<?php print $header['alamat']; ?>" placeholder="Alamat" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>
                    </div>  
                </div>
                <div class="col-md-6"> 
                    <div class="form-group"> 
                        <label class="control-label">Kota</label>                               
                        <input type="text" id="txtKota" class="form-control" value="<?php print $header['kota']; ?>" placeholder="Kota" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>
                    </div>  
                </div>
            </div> 
            <div class="row">
                <div class="col-md-6"> 
                    <div class="form-group"> 
                        <label class="control-label">Telepon</label>                               
                        <input type="text" id="txtTelepon" class="form-control" value="<?php print $header['telepon']; ?>" placeholder="Telepon" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>
                    </div>  
                </div>
                <div class="col-md-6"> 
                    <div class="form-group"> 
                        <label class="control-label">Email</label>                               
                        <input type="text" id="txtEmail" class="form-control" value="<?php print $header['email']; ?>" placeholder="Email" <?php if ($header['id'] > 0 && $mode == 'view') { ?> disabled="disabled" <?php } ?>>
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
      
                                                        <td>
                                                            <input type="text" id="txtMerk<?php print ($i+1); ?>" class="form-control text-right" value="<?php print $detail[$i]['merk']; ?>">
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
 var arrTipeBarang;
 function storeTblValues()
        {
            var TableData = new Array();
            
            $('#tblDetailBarang tbody tr').each(function(row, tr){
                TableData[row]={
                    "kode" : $(tr).find('td:eq(0) input[type="text"]').val(),
                    "nama" :  $(tr).find('td:eq(1) input[type="text"]').val(),                  
                    "merk" : $(tr).find('td:eq(2) input[type="text"]').val(),    
                           
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
                        '<input type="text" id="txtKode' + idx +'" class="form-control text-right" value="">' +   
                    '</td>' + 
                    '<td>' +
                         '<input type="text" id="txtNama' + idx +'" class="form-control text-right" value="">' +    
                    '</td>' + 

                    '<td>' +
                        '<input type="text" id="txtMerk' + idx +'" class="form-control text-right" value="">' +   
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

        FillTipe();
        $("#btnSubmit").click(function() {             
            var name = $("#txtNama").val();

            
            if (name == ''){ swal('Warning','Please enter Name','warning'); return false; }  
            
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
                    v_data.kodesupplier = $("#txtKode").val();              
                    v_data.nama = $("#txtNama").val();
                      v_data.alamat = $("#txtAlamat").val(); 
                      v_data.kota = $("#txtKota").val();
                      v_data.telepon = $("#txtTelepon").val();
                      v_data.email = $("#txtEmail").val();
                      v_data.tipe = $("#cmbTipe").val();                  
                    data["header"]  = JSON.stringify(v_data);
                    
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>admin/masterdata/savesupplier",
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
                                        location.href="<?php echo base_url();?>admin/masterdata/list_supplier";       
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