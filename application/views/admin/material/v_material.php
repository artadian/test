 <!-- .row -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
        	
            	<div class="panel-heading">    
                	<div class="row">
                    	<div class="col-md-12">     
                            Material
                        </div>
                    </div> 
                </div>
            	
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="tblMaterial" class="table display color-table success-table">
                            <thead>
                                <tr>              
                                    <th>Material</th>                                   
                                    <th>Material Desc</th>                                       
                                    <th>Material Group</th>                                   
                                    <th>Material Group Desc</th>    
                                    <th>Bal</th>    
                                    <th>Slof</th>    
                                    <th>Pac</th>    
                                </tr>
                            </thead>   
                            <tfoot>
                                <tr>        
                                    <th>Material</th>                                   
                                    <th>Material Desc</th>                                       
                                    <th>Material Group</th>                                   
                                    <th>Material Group Desc</th>    
                                    <th>Bal</th>    
                                    <th>Slof</th>    
                                    <th>Pac</th>            
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
		$('#tblMaterial thead tr').clone(true).appendTo( '#tblMaterial thead' );
		$('#tblMaterial thead tr:eq(1) th').each( function (i) {
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
								
		var table = $('#tblMaterial').DataTable({
			"orderCellsTop": true,
        	"fixedHeader": true,
			"pageLength" : 10,
			"ajax": {
				url : "<?php echo base_url();?>admin/material/get_list_material",
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