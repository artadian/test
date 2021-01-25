 <!-- .row -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
        	
            	<div class="panel-heading">    
                	<div class="row">
                    	<div class="col-md-8">     
                            Introdeal
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
                        <div class="col-md-6">                                    
                            <div class="form-group">
                                <label class="control-label">Sales Office</label>
                                <select id="cmbSalesOffice" class="form-control select2">
                                </select>                                        	
                            </div>
                        </div>  
                    </div>
                    <p class="text-muted m-b-30"></p>
                    <div class="table-responsive">
                        <table id="tblIntrodeal" class="table display color-table success-table">
                            <thead>
                                <tr>                            
                                    <th></th>           
                                    <th>Region</th>
                                    <th>Sales Office</th>
                                    <th>Material</th>
                                    <th>Qty Order</th>
                                    <th>Qty Bonus</th>                                             
                                    <th>Start Date</th>                                             
                                    <th>End Date</th>                                             
                                </tr>
                            </thead>   
                            <tfoot>
                                <tr>                            
                                    <th></th> 
                                    <th>Region</th>
                                    <th>Sales Office</th>          
                                    <th>Material</th>
                                    <th>Qty Order</th>
                                    <th>Qty Bonus</th>                                             
                                    <th>Start Date</th>                                             
                                    <th>End Date</th>      
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
 
 	function FillSalesOffice()
	{		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>admin/introdeal/getSalesOffice",
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
		
		FillSalesOffice();
		
		$("#cmbRegion").select2();
		$("#cmbSalesOffice").select2();
				
		$('#tblIntrodeal thead tr').clone(true).appendTo( '#tblIntrodeal thead' );
		$('#tblIntrodeal thead tr:eq(1) th').each( function (i) {
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
								
		var table = $('#tblIntrodeal').DataTable({
			"orderCellsTop": true,
        	"fixedHeader": true,
			"pageLength" : 10,
			"ajax": {
				url : "<?php echo base_url();?>admin/introdeal/get_list_introdeal",
				type : 'POST',
				data : function(data) {					
					data.regionid = $("#cmbRegion").val();
					data.salesofficeid = $("#cmbSalesOffice").val();		
				}				
			},
			'columnDefs': [
			  {
				 'targets': 0,
				 "data": null,            	 	 
				 "defaultContent": "<button type='button' class='btn btn-primary btn-circle btnEdit'><i class='fa fa-pencil'></i> </button> <button type='button' class='btn btn-success btn-circle btnView'><i class='fa fa-list'></i> </button> <button type='button' class='btn btn-danger btn-circle btnDelete'><i class='fa fa-close'></i> </button>",
				 "width": "12%"				 
			  },
			  {
				'targets': 6,
				// 'className': 'dt-body-right'
			}
		   ],		   
		   'order': [[1, 'asc']]
		});	
		
		$('#tblIntrodeal tbody').on('click', 'button.btnEdit', function () {
			var data = table.row( $(this).parents('tr') ).data();			
			location.href="<?php echo base_url();?>admin/introdeal/edit_introdeal/" + data[0];		
		});
		
		$("#cmbRegion").change(function() {	
			FillSalesOffice();
		});	
		
		$("#btnFilter").click(function() {		
			table.ajax.reload();
		});	
		
		$("#btnNew").click(function() {		
			location.href="<?php echo base_url();?>admin/introdeal/edit_introdeal/0";	
		});	
		
		$('#tblIntrodeal tbody').on('click', 'button.btnDelete', function () {
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
					url: "<?php echo base_url();?>admin/introdeal/delete_introdeal",
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
		
		$('#tblIntrodeal tbody').on('click', 'button.btnView', function () {
			var data = table.row( $(this).parents('tr') ).data();			
			location.href="<?php echo base_url();?>admin/introdeal/view_introdeal/" + data[0];		
		});
		
	}); 	
 </script>
 <style>
 	thead input {
        width: 100%;
    }
 </style>