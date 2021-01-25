 <!-- .row -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
        	
            	<div class="panel-heading">    
                	<div class="row">
                    	<div class="col-md-8">     
                            Trial
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
                                <label class="control-label">Trial Date</label>  
                                <div class="input-daterange input-group" id="date-range"> 
                                    <input class="form-control" type="date" id="rdpTglAwal" value="<?php print date("Y-m-d"); ?>" >
                                    <span class="input-group-addon bg-info b-0 text-white">to</span>
                                    <input class="form-control" type="date" id="rdpTglAkhir" value="<?php print date("Y-m-d"); ?>" >                           
                                </div>
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
                                <label class="control-label">Salesman</label>
                                <select id="cmbSalesman" class="form-control select2">							
                                </select>                                        	
                            </div>
                        </div>         
                    </div>
                    <p class="text-muted m-b-30"></p>
                    <div class="table-responsive">
                        <table id="tblTrial" class="table display color-table success-table">
                            <thead>
                                <tr>                            
                                    <th></th>           
                                    <th>Trial Date</th>
                                    <th>Salesman</th>
                                    <th>Trial Type</th>
                                    <th>Location</th>                                                        
                                    <th>Name</th>                                                        
                                    <th>Material</th>                                                        
                                </tr>
                            </thead>   
                            <tfoot>
                                <tr>                            
                                    <th></th>                            
                                    <th>Trial Date</th>
                                    <th>Salesman</th>
                                    <th>Trial Type</th>
                                    <th>Location</th>                                                        
                                    <th>Name</th>                                                        
                                    <th>Material</th>       
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
			url: "<?php echo base_url();?>admin/trial/getSalesOffice",
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
			url: "<?php echo base_url();?>admin/trial/getSalesman",
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
	
 	$(document).ready(function(){	
		
		FillSalesOffice();
		
		$("#cmbRegion").select2();
		$("#cmbSalesOffice").select2();
		$("#cmbSalesman").select2();
				
		$('#tblTrial thead tr').clone(true).appendTo( '#tblTrial thead' );
		$('#tblTrial thead tr:eq(1) th').each( function (i) {
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
								
		var table = $('#tblTrial').DataTable({
			"orderCellsTop": true,
        	"fixedHeader": true,
			"pageLength" : 10,
			"ajax": {
				url : "<?php echo base_url();?>admin/trial/get_list_trial",
				type : 'POST',
				data : function(data) {					
					data.regionid = $("#cmbRegion").val();
					data.salesofficeid = $("#cmbSalesOffice").val();
					data.salesmanid = $("#cmbSalesman").val();	
					data.tglawal = $("#rdpTglAwal").val();	
					data.tglakhir = $("#rdpTglAkhir").val();	
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
				'targets': 5,
				'className': 'dt-body-right'
			}
		   ],		   
		   'order': [[1, 'asc']]
		});	
		
		$('#tblTrial tbody').on('click', 'button.btnEdit', function () {
			var data = table.row( $(this).parents('tr') ).data();			
			location.href="<?php echo base_url();?>admin/trial/edit_trial/" + data[0];		
		});
		
		$("#cmbRegion").change(function() {	
			FillSalesOffice();
		});	
		
		$("#cmbSalesOffice").change(function() {		
			FillSalesman();
		});		
		
		$("#btnFilter").click(function() {		
			table.ajax.reload();
		});	
		
		$("#btnNew").click(function() {		
			location.href="<?php echo base_url();?>admin/trial/edit_trial/0";	
		});	
		
		$('#tblTrial tbody').on('click', 'button.btnDelete', function () {
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
					url: "<?php echo base_url();?>admin/trial/delete_trial",
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
		
		$('#tblTrial tbody').on('click', 'button.btnView', function () {
			var data = table.row( $(this).parents('tr') ).data();			
			location.href="<?php echo base_url();?>admin/trial/view_trial/" + data[0];		
		});
		
	}); 	
 </script>
 <style>
 	thead input {
        width: 100%;
    }
 </style>