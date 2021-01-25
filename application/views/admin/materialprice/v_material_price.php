 <!-- .row -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
        	
            	<div class="panel-heading">    
                	<div class="row">
                    	<div class="col-md-10">     
                            Material Price
                        </div>
                        <div class="col-md-2"> 
                            <button id="btnFilter" class="btn btn-block btn-danger btn-rounded btn-sm"><i class="fa fa-filter"></i> FILTER</button>
                        </div>
                    </div> 
                </div>
            	
                <div class="panel-body">
                	<div class="row">            	
                        <div class="col-md-6">                                    
                            <div class="form-group">
                                <label class="control-label">Price</label>  
                                <select id="cmbPrice" class="form-control select2">
                                    <?php foreach ($price as $pr): ?>		
                                        <option value="<?php echo $pr['id']; ?>"><?php echo $pr['name']; ?></option>
                                    <?php endforeach ?>
                                </select>          
                            </div>
                        </div>         
                    </div>
                    <div class="table-responsive">
                        <table id="tblMaterialPrice" class="table display color-table success-table">
                            <thead>
                                <tr>                  
                                    <th>Material</th>                                   
                                    <th>Material Desc</th>
                                    <th>Price</th>
                                    <th>Value</th>
                                    <th>Valid From</th>
                                    <th>Valid To</th>
                                </tr>
                            </thead>   
                            <tfoot>
                                <tr>                            
                                    <th>Material</th>                                   
                                    <th>Material Desc</th>
                                    <th>Price</th>
                                    <th>Value</th>
                                    <th>Valid From</th>
                                    <th>Valid To</th>           
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
 		$("#cmbPrice").select2();

		$('#tblMaterialPrice thead tr').clone(true).appendTo( '#tblMaterialPrice thead' );
		$('#tblMaterialPrice thead tr:eq(1) th').each( function (i) {
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
								
		var table = $('#tblMaterialPrice').DataTable({
			"orderCellsTop": true,
        	"fixedHeader": true,
			"pageLength" : 10,
			"ajax": {
				url : "<?php echo base_url();?>admin/materialprice/get_list_material_price",
				type : 'POST',
				data : function(data) {	
					data.price = $("#cmbPrice").val();
				}				
			},		   
		   	'order': [[1, 'asc']]
		});	
		
		$("#btnFilter").click(function() {		
			table.ajax.reload();
		});	
		
	}); 	
 </script>
 <style>
 	thead input {
        width: 100%;
    }
 </style>