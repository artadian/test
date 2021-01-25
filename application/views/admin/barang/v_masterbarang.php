 <!-- .row -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
        	
            	<div class="panel-heading">    
                	<div class="row">
                    	<div class="col-md-8">     
                            Master Barang
                        </div>
                        <div class="col-md-2"> 
                            <button id="btnFilter" class="btn btn-block btn-danger btn-rounded btn-sm"><i class="fa fa-filter"></i> FILTER</button>
                        </div>
                        <div class="col-md-2"> 
                            <button id="btnNew" class="btn btn-block btn-success btn-rounded btn-sm"><i class="fa fa-plus"></i> NEW</button>
                        </div>
                    </div> 
                    
                </div>
            	
                <div class="panel-body">                   
                    <p class="text-muted m-b-30"></p>
                    <div class="table-responsive">
                        <table id="tblPosm" class="table display color-table success-table">
                            <thead>
                                <tr>                            
                                    <!-- <th></th>                             -->
                                    <!-- <th>POSM No</th> -->
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Merk</th>
                                    <th>Supplier</th>                                              
                                </tr>
                            </thead>   
                            <tfoot>
                                <tr>                            
                                    <!-- <th></th>                             -->
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Merk Barang</th>
                                    <th>Nama Supplier</th>        
                                </tr>
                            </thead>                    
                            <tbody>                        
                            </tbody>
                        </table>
                    </div>
                </div>
        	
            
            
        </div>
    </div>
</div>
<!-- /.row -->
 
 <script type="text/javascript">
 	
 
	
 	$(document).ready(function(){	
		

				
		$('#tblPosm thead tr').clone(true).appendTo( '#tblPosm thead' );
		$('#tblPosm thead tr:eq(1) th').each( function (i) {
			var title = $(this).text();
			if (title != "") 
			{
				$(this).html( '<input type="text" class="bg-warning" placeholder="Search '+title+'" />' );
	 
				$( 'input', this ).on( 'keyup change', function () {
					if ( table.column(i).search() !== this.value ) {
						table
							.column(i)
							.search( this.value )
							.draw();
					}
				});	
			}
			
		});
								
		var table = $('#tblPosm').DataTable({
            "orderCellsTop": true,
            "fixedHeader": true,
            "pageLength" : 10,
            "ajax": {
                url : "<?php echo base_url();?>admin/masterdata/get_list_barang",
                type : 'POST',
                data : function(data) { }               
            }, 
           //  'columnDefs': [
           //    {
           //       'targets': 0,
           //       "data": null,                   
           //       "defaultContent": "<button type='button' class='btn btn-primary btn-circle btnEdit' title='Edit Customer'><i class='fa fa-pencil'></i></button> <button type='button' class='btn btn-success btn-circle btnView' title='View Customer'><i class='fa fa-list'></i> </button> <button type='button' class='btn btn-danger btn-circle btnDelete' title='Delete Customer'><i class='fa fa-close'></i> </button>",
           //       "width": "13%"              
           //    },
           //    {
           //      'targets': 1,
           //      //'className': 'dt-body-right'
           //  }
           // ],    
            'order': [[0, 'asc']]
        }); 
		
		$('#tblPosm tbody').on('click', 'button.btnEdit', function () {
			var data = table.row( $(this).parents('tr') ).data();			
			location.href="<?php echo base_url();?>admin/posm/edit_posm/" + data[0];		
		});
				
		
		$("#btnFilter").click(function() {		
			table.ajax.reload();
		});	
		
		$("#btnNew").click(function() {		
			location.href="<?php echo base_url();?>admin/masterdata/edit_barang/0";	
		});	
		
		$('#tblPosm tbody').on('click', 'button.btnDelete', function () {
			var data = table.row( $(this).parents('tr') ).data();			
			swal({
			  title: "Warning",
			  text: "Are you sure ?",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonClass: "btn-success",
			  confirmButtonText: "Yes, delete it!",
			  closeOnConfirm: false
			},
			function(){
				swal({ title: "", text: "", imageUrl: "<?php echo base_url(); ?>optimum/images/loading.gif", showConfirmButton: false, allowOutsideClick: false }); 
				
				$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>admin/posm/delete_posm",
					data: {id : data[0] },
					dataType: 'json',
					success: function(jsonData){						
						
						if (jsonData.responseCode=="200"){
							swal({
								title: "Save Success",allowEscapeKey:false,
								text: jsonData.responseMsg, type: "success",
								confirmButtonText: "OK", closeOnConfirm: false
							});                   
							table.ajax.reload();							
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
		
		$('#tblPosm tbody').on('click', 'button.btnView', function () {
			var data = table.row( $(this).parents('tr') ).data();			
			location.href="<?php echo base_url();?>admin/posm/view_posm/" + data[0];		
		});
		
	}); 	
 </script>
 <style>
 	thead input {
        width: 100%;
    }
 </style>