 <!-- .row -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
        	
            	<div class="panel-heading">    
                	<div class="row">
                    	<div class="col-md-12">     
                            Material Group
                        </div>
                    </div> 
                </div>
            	
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="tblMaterialGroup" class="table display color-table success-table">
                            <thead>
                                <tr>              
                                    <th>Code</th>                                   
                                    <th>Name</th>                                             
                                    <th>Description</th>                                                      
                                </tr>
                            </thead>   
                            <tfoot>
                                <tr>        
                                    <th>Code</th>                                   
                                    <th>Name</th>                                             
                                    <th>Description</th>            
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
		$('#tblMaterialGroup thead tr').clone(true).appendTo( '#tblMaterialGroup thead' );
		$('#tblMaterialGroup thead tr:eq(1) th').each( function (i) {
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
								
		var table = $('#tblMaterialGroup').DataTable({
			"orderCellsTop": true,
        	"fixedHeader": true,
			"pageLength" : 10,
			"ajax": {
				url : "<?php echo base_url();?>admin/materialgroup/get_list_material_group",
				type : 'POST',
				data : function(data) {	}				
			},	   
		    'order': [[1, 'asc']]
		});	
		
	}); 	
 </script>
 <style>
 	thead input {
        width: 100%;
    }
 </style>